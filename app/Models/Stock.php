<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item()
    {
        return $this->hasOne(StockItem::class, 'item_code', 'item_code');
    }
}
