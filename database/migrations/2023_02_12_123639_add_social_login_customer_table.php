<?php

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
        Schema::table('customers', static function (Blueprint $table) {
            $table->string('social_id')->nullable()->after('user_type');
            $table->string('social_type')->nullable()->after('social_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('customers', static function (Blueprint $table) {
            $table->dropColumn(['social_id']);
            $table->dropColumn(['social_type']);
        });
    }
};
