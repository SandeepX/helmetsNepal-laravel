<?php

use App\Models\Admin\User;
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
        Schema::create('coupons', static function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name')->unique();
            $table->string('campaign_code')->unique();
            $table->string('campaign_image');

            $table->string('coupon_type', 50);
            $table->double('coupon_value', 8, 2);

            $table->double('min_amount', 8, 2)->nullable();
            $table->double('max_amount', 8, 2)->nullable();

            $table->string('product_type')->nullable();

            $table->date('starting_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('status');
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

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
        Schema::dropIfExists('coupons');
    }
};
