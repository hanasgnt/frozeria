<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'item_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'note'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
