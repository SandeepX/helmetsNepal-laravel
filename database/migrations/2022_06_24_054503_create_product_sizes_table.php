<?php

use App\Models\Product\Product;
use App\Models\ProductAttribute\Size;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('product_sizes', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreignIdFor(Size::class)->nullable();
            $table->foreign('size_id')->references('id')->on('sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
