<?php

use App\Models\Product\Product;
use App\Models\ProductAttribute\Color;
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
        Schema::create('product_colors', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreignIdFor(Color::class, 'color_id_1')->nullable();
            $table->foreign('color_id_1')->references('id')->on('colors');
            $table->foreignIdFor(Color::class, 'color_id_2')->nullable();
            $table->foreign('color_id_2')->references('id')->on('colors');
            $table->string('product_image_color')->nullable();
            $table->boolean('color_gradient')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
