<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany(Stock::class, 'item_code', 'item_code');
    }
}
