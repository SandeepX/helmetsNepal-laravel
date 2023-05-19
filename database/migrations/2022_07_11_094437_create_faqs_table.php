<?php

use App\Models\Admin\User;
use App\Models\Faq\FaqCategory;
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
        Schema::create('faqs', static function (Blueprint $table) {
            $table->id();
            $table->mediumText('question');
            $table->longText('answer')->nullable();

            $table->foreignIdFor(FaqCategory::class,'faq_category_id')->nullable();
            $table->foreign('faq_category_id')->references('id')->on('faq_categories');

            $table->string('status');

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
        Schema::dropIfExists('faqs');
    }
};
