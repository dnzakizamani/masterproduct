<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_no',
        'date',
        'total',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that created the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the transaction details.
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get total items count.
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->details->sum('qty');
    }

    /**
     * Generate unique transaction number.
     */
    public static function generateTransactionNo(): string
    {
        $date = now()->format('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return 'TRX-' . $date . '-' . $random;
    }

    /**
     * Scope for searching transactions.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('transaction_no', 'like', '%' . $term . '%')
              ->orWhereHas('user', function ($userQuery) use ($term) {
                  $userQuery->where('name', 'like', '%' . $term . '%');
              });
        });
    }
}
