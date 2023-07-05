<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function sub__category()
    {
        return $this->belongsTo(Sub_Category::class);
    }
    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }
    public function favourites()
    {
        return $this->belongsTo(Favourite::class);
    }
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function product_nutrition()
    {
        return $this->hasMany(Product_Nutrition::class);
    }
}
