<?php

use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Order\OrderProductDetail;
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
        Schema::create('return_orders', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderProductDetail::class, 'order_product_detail_id')->nullable();
            $table->foreign('order_product_detail_id')->references('id')->on('order_product_details');

            $table->foreignIdFor(Product::class, 'product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->foreignIdFor(Customer::class, 'customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->dateTime('return_order_date');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->double('product_price', 10, 2)->default(0.0);
            $table->double('quantity', 10, 2)->default(0.0);
            $table->tinyInteger('terms_and_conditions')->default(0);
            $table->longText('note')->nullable();

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
        Schema::dropIfExists('return_orders');
    }
};
