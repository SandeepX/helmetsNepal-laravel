<?php

use App\Models\Customer\Customer;
use App\Models\Order\Coupon;
use App\Models\Order\DeliveryCharge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code');
            $table->dateTime('order_date');

            $table->foreignIdFor(Customer::class, 'customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');

            $table->string('payment_method_name')->nullable();
            $table->string('payment_transaction_id')->nullable();

            $table->string('delivery_status')->nullable();

            $table->decimal('coupon_value', 8, 2)->nullable();
            $table->string('coupon_code', 20)->nullable();
            $table->foreignIdFor(Coupon::class, 'coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons');


            $table->foreignIdFor(DeliveryCharge::class, 'deliveryCharge_id')->nullable();
            $table->foreign('deliveryCharge_id')->references('id')->on('delivery_charges');

            $table->decimal('sub_total', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('deliveryCharge_amount', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
