<?php

namespace Database\Seeders;

use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\AboutUsRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\DeliveryChargeRepository;
use App\Http\Repositories\FeatureCategoryRepository;
use App\Http\Repositories\PageBannerRepository;
use App\Http\Services\CategoryServices;
use App\Http\Services\DeliveryChargeServices;
use App\Http\Services\FeatureCategoryServices;
use App\Models\Admin\User;
use App\Models\Product\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $deliveryChargeRepository = new DeliveryChargeRepository();
        $categoryServices = new CategoryRepository();
        $featureCategoryRepository = new FeatureCategoryRepository();

        $aboutUsRepository = new AboutUsRepository();
        $cat = [
            [
                'name' => "Helmets",
                'slug' => Helper::getSlug('Helmets'),
                'parent_id' => null,
                'status' => EStatus::active,
                'created_by' => 1,
            ],

            [
                'name' => "Apparel",
                'slug' => Helper::getSlug('Apparel'),
                'parent_id' => null,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Accessories",
                'slug' => Helper::getSlug('Accessories'),
                'parent_id' => null,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Bags",
                'slug' => Helper::getSlug('bags'),
                'parent_id' => null,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Full Helmets",
                'slug' => Helper::getSlug('Full Helmets'),
                'parent_id' => 1,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Half Helmets",
                'slug' => Helper::getSlug('Half Helmets'),
                'parent_id' => 1,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Dirt Helmets",
                'slug' => Helper::getSlug('Dirt Helmets'),
                'parent_id' => 1,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Cycle Helmets",
                'slug' => Helper::getSlug('Cycle Helmets'),
                'parent_id' => 1,
                'status' => EStatus::active,
                'created_by' => 1,
            ],
            [
                'name' => "Shoes",
                'slug' => Helper::getSlug('Shoes'),
                'parent_id' => 2,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Bandanna",
                'slug' => Helper::getSlug('Bandanna'),
                'parent_id' => 2,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Boot",
                'slug' => Helper::getSlug('Boot'),
                'parent_id' => 2,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Jersey",
                'slug' => Helper::getSlug('Jersey'),
                'parent_id' => 2,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Action Camera",
                'slug' => Helper::getSlug('Action Camera'),
                'parent_id' => 3,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Cleaner",
                'slug' => Helper::getSlug('Cleaner'),
                'parent_id' => 3,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Goggles",
                'slug' => Helper::getSlug('Goggles'),
                'parent_id' => 3,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Paddock Stand",
                'slug' => Helper::getSlug('Paddock Stand'),
                'parent_id' => 3,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Visor",
                'slug' => Helper::getSlug('Visor'),
                'parent_id' => 3,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Action Camera Bag",
                'slug' => Helper::getSlug('Action Camera bag'),
                'parent_id' => 4,
                'status' => EStatus::active,
                'created_by' => 1,
            ], [
                'name' => "Cleaner Bags",
                'slug' => Helper::getSlug('Cleaner Bags'),
                'parent_id' => 4,
                'status' => EStatus::active,
                'created_by' => 1,
            ]

        ];

        $deliveryCharge_title = ["Inside Ring-road", "Outside Ring-road ", "Outside Valley",];
        $featureCategory_title = ["Flash Sale", "Feature Product", "Helmets", "Riding Gears", "Apparels", "Accessories"];
        try {
            DB::beginTransaction();
            $this->createUsers();

            foreach ($deliveryCharge_title as $value) {
                $deliveryChargeRepository->save([
                    'title' => $value,
                    'delivery_charge_amount' => 0.0,
                    'status' => EStatus::active,
                    'created_by' => 1,
                ]);
            }
            foreach ($cat as $value) {
                $categoryServices->save($value);
            }
            foreach ($featureCategory_title as $value) {
                $featureCategoryRepository->save([
                    'name' => $value,
                    'slug' => Helper::getSlugSimple($value),
                    'status' => EStatus::active,
                    'created_by' => 1,
                ]);
            }



            $aboutUsRepository->save([

                'about_us_title' => "",
                'about_us_sub_title' => "",
                'about_us_description' => "",

                'core_value_title' => "",
                'core_value_sub_title' => "",
                'core_value_description' => "",

                'who_we_are_title' => "",
                'who_we_are_sub_title' => "",
                'who_we_are_description' => "",
                'who_we_are_image' => "",
                'who_we_are_youtube' => "",

                'slogan_title' => "",
                'slogan_sub_title' => "",
                'slogan_description' => "",

                'slogan_title_1' => "",
                'slogan_description_1' => "",
                'slogan_title_2' => "",
                'slogan_description_2' => "",

                'team_title' => "",
                'team_description' => "",

                'career_title' => "",
                'career_sub_title' => "",
                'career_image' => "",

                'testimonial_title' => "",
                'testimonial_sub_title' => "",
                'testimonial_description' => "",

                'rider_story_title' => "",
                'rider_story_sub_title' => "",
                'rider_story_description' => "",
                'rider_story_image' => "",

                'showroom_title' => "",
                'showroom_description' => "",

                'brand_title' => "",
                'brand_description' => "",

                'newsletter_title' => "",
                'newsletter_description' => "",

                'blog_title' => "",
                'blog_sub_title' => "",
                'blog_description' => "",

                'flash_sale_title' => "",
                'flash_sale_description' => "",

                'created_by' => "1",
            ]);


            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dump($e);
        }

        $this->call([
            AdBlockSeeder::class,
            HomePageSectionSeeder::class,
            PageBannerSeeder::class,
        ]);
    }

    private function createUsers(): void
    {
        User::create([
            'name' => 'Administration',
            'email' => 'super_admin@admin.com',
            'username' => 'super_admin@admin.com',
            'last_login' => date('Y-m-d h:i:s'),
            'last_login_ipAddress' => '127.0.0.1',
            'user_type' => 'super_admin',
            'password' => Helper::passwordHashing("super_admin@admin.com"),
            'status' => '1',
        ]);
    }
}
