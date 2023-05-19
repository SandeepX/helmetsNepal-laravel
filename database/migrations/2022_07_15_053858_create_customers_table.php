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
        Schema::create('customers', static function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();

            $table->string('primary_contact_1')->nullable();
            $table->string('Secondary_contact_1')->nullable();

            $table->string('primary_contact_2')->nullable();
            $table->string('Secondary_contact_2')->nullable();

            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();

            $table->boolean('is_verified')->default(0);
            $table->dateTime('email_verified_at')->nullable();

            $table->string('user_type')->nullable();

            $table->boolean('status')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->string('last_login_ipAddress')->nullable();

            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
};
