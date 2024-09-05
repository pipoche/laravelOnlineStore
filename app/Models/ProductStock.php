<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'stockquantity',
        'product_id',
    ];
    protected $table = 'product_stock';
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
