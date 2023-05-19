<?php

use App\Models\Admin\User;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Manufacture;
use App\Models\Product\ProductGraphic;
use App\Models\Product\ProductModel;
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
    public function up()
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('product_code')->unique()->nullable();
            $table->string('slug');
            $table->string('cover_image')->nullable();


            $table->longText('short_details')->nullable();
            $table->longText('details')->nullable();

            $table->bigInteger('product_price');

            $table->string('sku')->nullable();

            $table->string('tag_type')->nullable();
            $table->string('tag_name')->nullable();


            $table->foreignIdFor(Category::class)->nullable();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->foreignIdFor(Brand::class)->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');

            $table->foreignIdFor(ProductGraphic::class)->nullable();
            $table->foreign('product_graphic_id')->references('id')->on('product_graphics');

            $table->foreignIdFor(ProductModel::class)->nullable();
            $table->foreign('product_model_id')->references('id')->on('product_models');

            $table->foreignIdFor(Manufacture::class)->nullable();
            $table->foreign('manufacture_id')->references('id')->on('manufactures');


            $table->boolean('size_status')->default(0);
            $table->boolean('color_status')->default(0);
            $table->boolean('custom_status')->default(0);

            $table->boolean('is_approved')->default(0);

            $table->text('meta_title')->nullable();
            $table->text('meta_keys')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('alternate_text')->nullable();

            $table->boolean('is_feature')->default(0);
            $table->boolean('is_returnable')->default(0);
            $table->string('status')->default(0);

            $table->double('quantity',10,2)->default(0.0);
            $table->double('minimum_quantity',10,2)->default(0.0);
            $table->double('vendor_price',10,2)->default(0.0);

            $table->foreignIdFor(User::class, 'is_approved_by')->nullable();
            $table->foreign('is_approved_by')->references('id')->on('users');

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
        Schema::dropIfExists('products');
    }
};
