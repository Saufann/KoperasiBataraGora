<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'status',
        'description',
        'image'
    ];
    

    /**
     * Relasi ke OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }
}
