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
        Schema::create('showrooms', static function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('address');
            $table->longText('google_map_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('email');
            $table->string('contact_no');
            $table->string('contact_person');
            $table->string('showroom_image');
            $table->string('status');
            $table->boolean('is_feature')->default(0);
            $table->boolean('show_in_contactUs')->default(0);

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
    public function down(): void
    {
        Schema::dropIfExists('showrooms');
    }
};
