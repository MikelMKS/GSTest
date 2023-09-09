<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationsTypes;

class NotificationsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationsTypes::insert([
            ['name' => 'SMS'],
            ['name' => 'E-Mail'],
            ['name' => 'Push Notification']
        ]);
    }
}
