<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function stockTransaction()
    {
        return $this->belongsTo(StockTransaction::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
