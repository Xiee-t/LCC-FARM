<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public $timestamps = false; // No timestamps in table

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'products',
        'rating',
        'status',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];

    /**
     * Get orders placed by this supplier (name match).
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'supplier', 'name');
    }
}

