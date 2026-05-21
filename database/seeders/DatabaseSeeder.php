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
        $password = \Illuminate\Support\Str::password(12);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make($password),
            ]
        );

        $this->command->info('Admin email: admin@example.com');
        $this->command->info('Admin password: ' . $password);
    }
}
