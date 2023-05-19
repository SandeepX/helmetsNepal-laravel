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
    public function up()
    {
        Schema::create('product_discounts', static function (Blueprint $table) {
            $table->id();
            $table->double('discount_percent')->nullable();
            $table->double('discount_amount')->nullable();

            $table->dateTime('discount_start_date')->nullable();
            $table->dateTime('discount_end_date')->nullable();

            $table->string('status')->default(0);

            $table->foreignIdFor(Product::class)->nullable();
            $table->foreign('product_id')->references('id')->on('products');

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
    public function down()
    {
        Schema::dropIfExists('product_discounts');
    }
};
