<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'new_price',
        'id_product',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
