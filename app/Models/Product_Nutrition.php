<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Nutrition extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    public function nutritions()
    {
        return $this->belongsTo(Nutrition::class);
    }
}
