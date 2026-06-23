<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock'),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::sum('total'),
        ];

        $recentTransactions = Transaction::with(['user', 'details'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->where('status', true)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.pages.dashboard', compact(
            'stats',
            'recentTransactions',
            'lowStockProducts'
        ));
    }
}
