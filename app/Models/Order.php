<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false; // Only created_at, no updated_at

    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'supplier',
        'product',
        'quantity',
        'expected_delivery',
        'status',
        'total_price',
        'distributor_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the supplier that placed this order.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'name');
    }

    /**
     * Get the product ordered.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product', 'name');
    }

    /**
     * Scope for pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Scope for orders this month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for recent orders.
     */
    public function scopeRecent($query)
    {
        return $query->latest()->take(10);
    }

    /**
     * Get the distributor who accepted this order.
     */
    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id');
    }
}

