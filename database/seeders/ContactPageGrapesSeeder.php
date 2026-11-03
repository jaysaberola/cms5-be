<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ContactPageGrapesSeeder extends Seeder
{
    public function run(): void
    {
        $dataDir = database_path('seeders/data');
        $html = file_get_contents($dataDir . '/contact_grapes.html');
        $css = file_get_contents($dataDir . '/contact_grapes.css');
        $js = file_get_contents($dataDir . '/contact_grapes.js');

        Page::updateOrCreate(
            ['slug' => 'contact-us'],
            [
                'parent_page_id' => null,
                'album_id' => 4,
                'name' => 'Contact Us',
                'label' => 'Contact Us',
                'contents' => '',
                'grapes_html' => trim($html),
                'grapes_css' => trim($css),
                'grapes_js' => trim($js),
                'content_type' => 'grapes',
                'status' => 'published',
                'page_type' => 'standard',
                'user_id' => 1,
            ]
        );
    }
}
