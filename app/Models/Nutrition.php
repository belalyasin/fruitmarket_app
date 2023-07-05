<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    use HasFactory;

    public function product_nutrition()
    {
        return $this->hasMany(Product_Nutrition::class);
    }
}
