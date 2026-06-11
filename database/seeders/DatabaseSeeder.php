<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrNew(['email' => 'admin@example.com']);
        $user->name = 'Admin';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->role = 'admin';
        $user->save();

        $this->command->info('Admin email: admin@example.com');
        $this->command->info('Admin password: admin123');

        // Seed 15 Dummy Blogs
        $dummyImages = [
            'blogs/E6Bj5OeHGA95ZKJFbKzF9jTQkhWpnFqKGp5yqy0U.png',
            'blogs/oRTfYNJrUnWa61AA3uHBfnfjuzjkr1aga7iLDjhu.png',
            'blogs/PK8cvOrXNFZSpXFRAKVa19QUkznau5yfxeamvwvM.jpg',
            null
        ];

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\BlogDetail::truncate();
        \App\Models\Blog::truncate(); // Clear existing blogs to keep it clean
        \App\Models\PressReleaseDetail::truncate();
        \App\Models\PressRelease::truncate(); // Clear existing press releases
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        for ($i = 1; $i <= 15; $i++) {
            \App\Models\Blog::create([
                'title' => "Top Emerging Technologies Transforming Global Industries in " . (2025 + $i),
                'description' => "This is a dummy blog description for article number {$i}. Exploring the key technologies, trends, and framework shaping growth opportunities worldwide. From AI and automation to clean energy, we look at what's next for businesses.",
                'url' => "blog-post-{$i}",
                'author_name' => "Expert Analyst " . ($i % 3 + 1),
                'image' => $dummyImages[($i - 1) % count($dummyImages)],
            ]);
        }
        $this->command->info('15 dummy blogs seeded successfully!');

        // Seed 15 Dummy Press Releases
        $dummyPrImages = [
            'press_releases/thumbnails/3oPRxJ85hjddJN1B1Go3WeQ9TPHIZHG07mywgVGJ.jpg',
            'press_releases/thumbnails/5a7c2qVhmMk3fuapGTuk4Dmv3tekKH491prVwUef.png',
            'press_releases/thumbnails/z35Rqob1yoJk0zx5aXkFDWiSpajlxW5s2yVkb6dg.png',
            'press_releases/k9YeGo5kQe8fYVZ6tK3BlNrDnfNXkpobWw6Uxtq4.jpg'
        ];

        for ($i = 1; $i <= 15; $i++) {
            \App\Models\PressRelease::create([
                'title' => ($i % 3 === 0) ? "Renewable Energy Sector Set for Significant Expansion Over the Next Decade" : (($i % 2 === 0) ? "Electric Vehicle Market Sees Surge as Global Adoption Accelerates" : "AI Market Expected to Reach $1.5 Trillion by 2030, Driven by Rapid Enterprise Adoption"),
                'description' => "Our latest research highlights the accelerating demand for key technologies driving global growth opportunities. From artificial intelligence and data networks to sustainable energy solutions, this release details market valuations, forecast timelines, and competitive strategies.",
                'url' => "press-release-{$i}",
                'status' => 'Active',
                'thumbnail_image' => $dummyPrImages[($i - 1) % count($dummyPrImages)],
            ]);
        }
        $this->command->info('15 dummy press releases seeded successfully!');
    }
}
