<?php

namespace Database\Seeders;

use App\Http\Enums\EStatus;
use App\Http\Repositories\AdBlockRepository;
use Illuminate\Database\Seeder;
use Throwable;

class AdBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $_adBlocks = ['shopTopSectionOne', 'shopTopSectionTwo', 'shopSectionBody', 'shopBottomSectionOne', 'shopBottomSectionTwo', 'homeSectionBody'];
        try {
            foreach ($_adBlocks as $value) {
                $adBlock = new AdBlockRepository();
                $adBlock->save([
                    'section' => $value,
                    'status' => EStatus::inactive
                ]);
                echo 'ok';
            }
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}
