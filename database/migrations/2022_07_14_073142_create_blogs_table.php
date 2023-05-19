<?php

use App\Models\Admin\User;
use App\Models\Blog\BlogCategory;
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
        Schema::create('blogs', static function (Blueprint $table) {
            $table->id();
            $table->mediumText('title');
            $table->string('blog_image');
            $table->longText('description');
            $table->string('blog_created_by');
            $table->string('blog_creator_image');
            $table->date('blog_publish_date');
            $table->string('blog_read_time');

            $table->foreignIdFor(BlogCategory::class, 'blog_category_id')->nullable();
            $table->foreign('blog_category_id')->references('id')->on('blog_categories');

            $table->string('status');
            $table->boolean('is_featured')->default(0);

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
        Schema::dropIfExists('blogs');
    }
};
