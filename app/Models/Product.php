<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'id_category',
        'producttype',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(category::class, 'id_category');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_product');
    }

    public function promotions()
    {
        return $this->hasOne(Promotion::class, 'id_product');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class, 'pack_product');
    }

    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }


}
