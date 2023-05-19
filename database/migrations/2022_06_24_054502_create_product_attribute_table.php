<?php

use App\Models\Admin\User;
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
    public function up(): void
    {
        Schema::create('product_attributes', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('product_attributes_one');
            $table->string('product_attributes_one_type');
            $table->string('product_attributes_one_value');

            $table->string('product_attributes_two');
            $table->string('product_attributes_two_type');
            $table->string('product_attributes_two_value');

            $table->string('product_attributes_three');
            $table->string('product_attributes_three_type');
            $table->string('product_attributes_three_value');

            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('product_attribute_titles');
    }
};
