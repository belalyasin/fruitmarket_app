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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
        // return $this->belongsTo(Cart::class);
    }
    public function favourites()
    {
        return $this->hasMany(Favourite::class);
        // return $this->belongsTo(Favourite::class);
    }
    public function orders()
    {
        return $this->hasMany(Order_Product::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->rates->avg('rate');
    }

    public function product_nutrition()
    {
        return $this->hasMany(Product_Nutrition::class);
    }
}
