<?php

use App\Models\Order\Order;
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
        Schema::create('order_product_details', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class, 'order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->foreignIdFor(Product::class, 'product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('product_code')->nullable();
            $table->double('product_price', 10, 2)->default(0.0);
            $table->double('quantity', 10, 2)->default(0.0);
            $table->decimal('total', 10, 2)->default(0.0);

            $table->string('product_custom_attributes')->nullable();
            $table->string('product_custom_attribute_value')->nullable();

            $table->foreignIdFor(ProductColor::class, 'product_color_id')->nullable();
            $table->foreign('product_color_id')->references('id')->on('product_colors');

            $table->foreignIdFor(ProductSize::class, 'product_size_id')->nullable();
            $table->foreign('product_size_id')->references('id')->on('product_sizes');

            $table->string('product_color')->nullable();
            $table->string('product_size')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product_details');
    }
};
