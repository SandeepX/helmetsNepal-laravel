<?php

use App\Models\Admin\User;
use App\Models\Career\Department;
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
        Schema::create('careers', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('salary_details')->nullable();
            $table->longText('description');

            $table->foreignIdFor(Department::class, 'department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');

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
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
