<?php

use App\Models\Cart\Cart;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\Product\ProductSize;
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
        Schema::create('cart_products', static function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Cart::class, 'cart_id')->nullable();
            $table->foreign('cart_id')->references('id')->on('carts');

            $table->foreignIdFor(Product::class, 'product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('product_custom_attributes')->nullable();
            $table->string('product_custom_attribute_value')->nullable();

            $table->foreignIdFor(ProductColor::class, 'product_color_id')->nullable();
            $table->foreign('product_color_id')->references('id')->on('product_colors');

            $table->foreignIdFor(ProductSize::class, 'product_size_id')->nullable();
            $table->foreign('product_size_id')->references('id')->on('product_sizes');

            $table->string('product_color')->nullable();
            $table->string('product_size')->nullable();


            $table->decimal('product_price', 8, 2)->nullable();
            $table->decimal('quantity', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_products');
    }
};
