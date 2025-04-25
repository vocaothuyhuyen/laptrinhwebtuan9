<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'name', 'description', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
