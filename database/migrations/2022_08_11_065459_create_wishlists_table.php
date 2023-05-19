<?php

use App\Models\Customer\Customer;
use App\Models\Product\Product;
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
        Schema::create('wishlists', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->foreignIdFor(Customer::class, 'customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('wishlists');
    }
};
