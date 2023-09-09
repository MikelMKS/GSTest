<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
        [
            CategoriesSeeder::class,
            NotificationsTypesSeeder::class
        ],
            Users::factory(30)->create()
        );
    }
}
