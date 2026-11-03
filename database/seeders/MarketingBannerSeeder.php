<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MarketingBannerSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 1;

        $home = Album::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Home Main Banner',
                'transition_in' => 1,
                'transition_out' => 2,
                'transition' => 6,
                'type' => 'main_banner',
                'banner_type' => 'image',
                'user_id' => $userId,
            ]
        );

        $about = Album::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'About Sub Banner',
                'transition_in' => 21,
                'transition_out' => 20,
                'transition' => 5,
                'type' => 'sub_banner',
                'banner_type' => 'image',
                'user_id' => $userId,
            ]
        );

        $news = Album::updateOrCreate(
            ['id' => 3],
            [
                'name' => 'News Sub Banner',
                'transition_in' => 21,
                'transition_out' => 20,
                'transition' => 5,
                'type' => 'sub_banner',
                'banner_type' => 'image',
                'user_id' => $userId,
            ]
        );

        $contact = Album::updateOrCreate(
            ['id' => 4],
            [
                'name' => 'Contact Sub Banner',
                'transition_in' => 21,
                'transition_out' => 20,
                'transition' => 5,
                'type' => 'sub_banner',
                'banner_type' => 'image',
                'user_id' => $userId,
            ]
        );

        Banner::query()->whereIn('album_id', [$home->id, $about->id, $news->id, $contact->id])->delete();

        $slides = [
            $home->id => [
                [
                    'title' => 'Build a consulting business that works.',
                    'description' => 'Work with fewer, better-fit clients. Raise your rates. Build offers that scale without burning you out.',
                    'alt' => 'For consultants, coaches & experts',
                    'image_path' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1600&q=80',
                    'button_text' => 'Book a call|Learn more',
                    'url' => '/public/contact-us|/public/about-us',
                    'order' => 1,
                ],
                [
                    'title' => 'Designed for experts who want to work smarter.',
                    'description' => 'Clarify your offer, streamline delivery, and give clients an experience that feels effortless—editable in WebFocus CMS.',
                    'alt' => 'WebFocus CMS demo',
                    'image_path' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1600&q=80',
                    'button_text' => 'Learn more',
                    'url' => '/public/about-us',
                    'order' => 2,
                ],
            ],
            $about->id => [
                [
                    'title' => 'About WebFocus',
                    'description' => 'Philippine team, enterprise hosting, and a visual CMS your clients will actually use.',
                    'image_path' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80',
                    'order' => 1,
                ],
            ],
            $news->id => [
                [
                    'title' => 'News & Updates',
                    'description' => 'Publish announcements and stories from the same editor as your landing pages.',
                    'image_path' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1600&q=80',
                    'order' => 1,
                ],
            ],
            $contact->id => [
                [
                    'title' => 'Let’s talk',
                    'description' => 'Request a sandbox, pricing, or a guided tour of the visual builder.',
                    'image_path' => 'https://images.unsplash.com/photo-1423666639041-f56000c27a9f?auto=format&fit=crop&w=1600&q=80',
                    'order' => 1,
                ],
            ],
        ];

        Page::query()->where('slug', 'home')->update(['album_id' => $home->id]);
        Page::query()->whereIn('slug', ['about', 'about-us'])->update(['album_id' => $about->id]);
        Page::query()->where('slug', 'news')->update(['album_id' => $news->id]);
        Page::query()->where('slug', 'contact-us')->update(['album_id' => $contact->id]);

        foreach ($slides as $albumId => $items) {
            foreach ($items as $item) {
                Banner::create([
                    'album_id' => $albumId,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'alt' => $item['alt'] ?? $item['title'],
                    'image_path' => $item['image_path'],
                    'button_text' => $item['button_text'] ?? null,
                    'url' => $item['url'] ?? null,
                    'order' => $item['order'],
                    'user_id' => $userId,
                ]);
            }
        }
    }
}
