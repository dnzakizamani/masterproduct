<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Get the transaction details for the product.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Scope a query to search products by name or SKU.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
              ->orWhere('sku', 'like', '%' . $term . '%');
        });
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include inactive products.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    /**
     * Scope a query to only include products with low stock.
     */
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->whereBetween('stock', [1, $threshold]);
    }

    /**
     * Scope a query to only include out of stock products.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', 0);
    }
}
