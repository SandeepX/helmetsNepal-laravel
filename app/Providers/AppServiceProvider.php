<?php

namespace App\Providers;

use App\Http\Enums\EStatus;
use App\Http\Repositories\FeatureCategoryRepository;
use App\Models\FeatureCategory\FeatureCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('feature_categories')) {
            $_featureCategoryList = FeatureCategory::where('status' , EStatus::active)->get();
            view()->composer('admin.include.sidebar', function ($view) use ($_featureCategoryList) {
                $view->with('_featureCategoryList', $_featureCategoryList);
            });


        }
    }
}
