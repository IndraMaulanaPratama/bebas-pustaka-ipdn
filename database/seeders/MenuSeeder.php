<?php

namespace Database\Seeders;

use App\Models\Akses;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMenu = [
            'MENU_ID' => uuid_create(4),
            'MENU_NAME' => fake()->word,
            // 'MENU_ICON',
            'MENU_DESCRIPTION' => fake()->sentence,
            'MENU_URL' => Str::slug("Ini data dummy"),
        ];

        Menu::create($dataMenu);
    }
}
