<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Traits\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    use FlashMessage;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Product::query();

        // Search using scope
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->inactive();
            }
        }

        // Filter by stock
        if ($request->has('stock') && $request->stock) {
            if ($request->stock === 'low') {
                $query->lowStock();
            } elseif ($request->stock === 'out') {
                $query->outOfStock();
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $products = $query->paginate(10)->withQueryString();

        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * Display trashed (deleted) products.
     */
    public function trashed(): View
    {
        $products = Product::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('admin.pages.products.trashed', compact('products'));
    }

    /**
     * Restore a trashed product.
     */
    public function restore(string $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', 'Product restored successfully.');
    }

    /**
     * Force delete a trashed product.
     */
    public function forceDelete(string $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()
            ->route('admin.products.trashed')
            ->with('success', 'Product permanently deleted.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('admin.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('admin.pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product moved to trash.');
    }
}
