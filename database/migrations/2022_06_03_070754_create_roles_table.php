<?php

use App\Models\Admin\User;
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
        Schema::create('roles', static function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name')->unique();
            $table->boolean('status');

            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->foreignIdFor(User::class,'updated_by')->nullable();
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
        Schema::dropIfExists('roles');
    }
};
