<?php

namespace Database\Seeders;

use App\Http\Repositories\PageBannerRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class PageBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $pageBannerRepository = new PageBannerRepository();

        try {
            DB::beginTransaction();
            $page_banners_name = ["about_us", "team_list", "team_detail", "blog_list", "contact_us", "career_list", "career_detail", "showroom_list" , 'faq' , 'shop','item_listing'];
            foreach ($page_banners_name as $value) {
                $page_banner = $pageBannerRepository->getPageBannerByName($value);
                if(is_null($page_banner)){
                    $pageBannerRepository->save([
                        'page_name' => $value,
                        'page_title' => "-",
                        'page_sub_title' => "",
                        'page_title_description' => "",
                        'page_image' => "",
                        'created_by' => 1,
                    ]);
                }
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dump($e);
        }
    }
}
