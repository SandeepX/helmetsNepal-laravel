<?php

use App\Models\Admin\User;
use App\Models\Team\Designation;
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
        Schema::create('team', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->longText('description')->nullable();

            $table->foreignIdFor(Designation::class,'designation_id')->nullable();
            $table->foreign('designation_id')->references('id')->on('designations');
            $table->string('status');
            $table->boolean('is_featured')->default(0);

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
        Schema::dropIfExists('team');
    }
};
