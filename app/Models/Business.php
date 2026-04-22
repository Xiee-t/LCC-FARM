<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'business_name',
        'address',
        'contact_person',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suppliedOrders()
    {
        return $this->hasMany(Order::class, 'supplier_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'distributor_id');
    }
}
