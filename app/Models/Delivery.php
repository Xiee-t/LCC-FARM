<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'distributor_id',
        'delivery_status',
        'delivery_address',
        'suggested_sequence',
        'actual_delivery_time',
    ];

    protected $casts = [
        'suggested_sequence' => 'integer',
        'actual_delivery_time' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Business::class, 'distributor_id');
    }
}
