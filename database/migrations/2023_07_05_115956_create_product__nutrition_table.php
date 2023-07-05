<?php

use App\Models\Nutrition;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product__nutrition', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Nutrition::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product__nutrition');
    }
};
