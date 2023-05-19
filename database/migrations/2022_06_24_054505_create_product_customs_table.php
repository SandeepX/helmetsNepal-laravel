<?php

use App\Models\Product\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_customs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('product_custom_attributes');
            $table->string('product_custom_attribute_value');
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
        Schema::dropIfExists('product_customs');
    }
};
