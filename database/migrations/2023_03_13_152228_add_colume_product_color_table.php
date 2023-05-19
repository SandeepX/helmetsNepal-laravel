<?php

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
        Schema::table('product_colors', static function (Blueprint $table) {
            $table->double('quantity')->default(0.0)->after('product_image_color');
            $table->string('barcode')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_colors', static function (Blueprint $table) {
            $table->dropColumn(['quantity']);
            $table->dropColumn(['barcode']);
        });
    }
};
