<?php

namespace Database\Seeders;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {

        $dataMenu = [
            'MENU_ID' => uuid_create(4),
            'MENU_NAME' => fake()->word,
            // 'MENU_ICON',
            'MENU_DESCRIPTION' => fake()->sentence,
            'MENU_URL' => Str::slug("ini data dummy"),
        ];

        $dataRole = [
            "ROLE_ID" => uuid_create(4),
            "ROLE_NAME" => fake()->word,
        ];

        $dataUser = [
            "user_role" => $dataRole['ROLE_ID'],
            "name" => fake()->name(),
            "email" => fake()->email(),
            "email_verified_at" => now()->timestamp,
            "password" => bcrypt("password"),
        ];

        $dataPivotMenu = [
            'PIVOT_ID' => uuid_create(4),
            'PIVOT_MENU' => $dataMenu['MENU_ID'],
            'PIVOT_ROLE' => $dataRole['ROLE_ID'],
            'PIVOT_DESCRIPTION' => fake()->sentence,
        ];

        $dataAkses = [
            'ACCESS_ID' => uuid_create(4),
            'ACCESS_NAME' => fake()->word,
            'ACCESS_MENU' => $dataPivotMenu['PIVOT_ID'],
            'ACCESS_CREATE' => random_int(0, 1),
            'ACCESS_READ' => random_int(0, 1),
            'ACCESS_UPDATE' => random_int(0, 1),
            'ACCESS_DELETE' => random_int(0, 1),
            'ACCESS_RESTORE' => random_int(0, 1),
            'ACCESS_DESTROY' => random_int(0, 1),
            'ACCESS_DETAIL' => random_int(0, 1),
            'ACCESS_VIEW' => random_int(0, 1),
        ];

            Role::create($dataRole);
            User::create($dataUser);
            Menu::create($dataMenu);
            pivotMenu::create($dataPivotMenu);
            Akses::create($dataAkses);

        }

    }
}