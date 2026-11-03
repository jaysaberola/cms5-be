<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/** Re-apply Executra Grapes + marketing banners across the public demo site. */
class ExecutraSiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MarketingBannerSeeder::class,
            HomePageGrapesSeeder::class,
            AboutPageGrapesSeeder::class,
            ContactPageGrapesSeeder::class,
            FooterPageGrapesSeeder::class,
        ]);
    }
}
