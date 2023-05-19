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
    public function up(): void
    {
        Schema::create('about_us', static function (Blueprint $table) {
            $table->id();

            $table->string('about_us_title')->nullable();
            $table->string('about_us_sub_title')->nullable();
            $table->text('about_us_description')->nullable();

            $table->string('core_value_title')->nullable();
            $table->string('core_value_sub_title')->nullable();
            $table->text('core_value_description')->nullable();

            $table->string('who_we_are_title')->nullable();
            $table->string('who_we_are_sub_title')->nullable();
            $table->text('who_we_are_description')->nullable();
            $table->text('who_we_are_image')->nullable();
            $table->text('who_we_are_youtube')->nullable();


            $table->string('slogan_title')->nullable();
            $table->string('slogan_sub_title')->nullable();
            $table->text('slogan_description')->nullable();

            $table->text('slogan_title_1')->nullable();
            $table->text('slogan_description_1')->nullable();
            $table->text('slogan_title_2')->nullable();
            $table->text('slogan_description_2')->nullable();

            $table->text('team_title')->nullable();
            $table->text('team_description')->nullable();


            $table->string('career_title')->nullable();
            $table->string('career_sub_title')->nullable();
            $table->text('career_image')->nullable();


            $table->string('testimonial_title')->nullable();
            $table->string('testimonial_sub_title')->nullable();
            $table->text('testimonial_description')->nullable();

            $table->string('rider_story_title')->nullable();
            $table->string('rider_story_sub_title')->nullable();
            $table->string('rider_story_description')->nullable();
            $table->text('rider_story_image')->nullable();

            $table->string('showroom_title')->nullable();
            $table->text('showroom_description')->nullable();

            $table->string('brand_title')->nullable();
            $table->text('brand_description')->nullable();

            $table->string('newsletter_title')->nullable();
            $table->text('newsletter_description')->nullable();

            $table->string('blog_title')->nullable();
            $table->string('blog_sub_title')->nullable();
            $table->text('blog_description')->nullable();


            $table->string('contactUs_title')->nullable();
            $table->text('contactUs_description')->nullable();

            $table->string('contactUsGetInTouch_title')->nullable();
            $table->text('contactUsGetInTouch_description')->nullable();

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
        Schema::dropIfExists('about_us');
    }
};
