<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EggProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'egg_products';

    protected $fillable = [
        'category',
        'price_per_unit',
        'stock_quantity',
        'low_stock_threshold',
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
