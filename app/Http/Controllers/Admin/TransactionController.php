<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Traits\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    use FlashMessage;

    public function __construct(
        private TransactionService $transactionService
    ) {}

    public function index(Request $request): View
    {
        $query = Transaction::with(['user', 'details']);

        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $transactions = $query->paginate(15)->withQueryString();

        return view('admin.pages.transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        $products = Product::active()
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('admin.pages.transactions.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        foreach ($validated['items'] as $index => $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock < $item['qty']) {
                return back()
                    ->withInput()
                    ->withErrors(["items.{$index}.qty" => "Insufficient stock for {$product->name}"]);
            }
        }

        $transaction = $this->transactionService->createTransaction($validated);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaction created successfully!');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['details.product', 'user']);

        return view('admin.pages.transactions.show', compact('transaction'));
    }
}
