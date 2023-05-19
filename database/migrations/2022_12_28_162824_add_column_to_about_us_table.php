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
    public function up(): void
    {
        Schema::table('about_us', static function (Blueprint $table) {
            $table->text('flash_sale_title')->nullable()->after('contactUsGetInTouch_description');
            $table->text('flash_sale_description')->nullable()->after('flash_sale_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('about_us', static function (Blueprint $table) {
            $table->dropColumn(['flash_sale_title','flash_sale_description']);
        });
    }
};
