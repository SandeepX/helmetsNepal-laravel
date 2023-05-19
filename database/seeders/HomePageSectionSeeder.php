<?php

namespace Database\Seeders;

use App\Http\Enums\EStatus;
use App\Models\Setting\HomePageSection;
use Illuminate\Database\Seeder;
use Throwable;

class HomePageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $_homePageSection = ['Category Section', 'Featured Item section', 'Ultimate tagline section (flash sale)', 'Who we are video section', 'brief about company section', 'Service slider section', 'Rider story section'];
        try {
            foreach ($_homePageSection as $value) {

                HomePageSection::create([
                    'name' => $value,
                    'position' => 0,
                    'status' => EStatus::active
                ]);
                echo 'ok';
            }
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}
