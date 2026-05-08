<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
         'name',
        'category_id',
        'stock',
        'minimum_stock',
        'unit',
        'selling_price',
        'purchase_price',
        'weight',
        'storage_location',
        'description',
        'photo',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}