<?php

namespace Database\Seeders;

use App\Models\Akses;
use App\Models\Menu;
use App\Models\pivotMenu;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataRole = [
            [
                "ROLE_ID" => uuid_create(4),
                "ROLE_NAME" => "Super Admin",
            ],
            [
                "ROLE_ID" => uuid_create(4),
                "ROLE_NAME" => "Admin Pustaka",
            ],
            [
                "ROLE_ID" => uuid_create(4),
                "ROLE_NAME" => "Praja Utama",
            ],

        ];

        $dataUser = [
            [
                // "id" => uuid_create(4),
                "user_role" => $dataRole[0]['ROLE_ID'],
                "name" => "Rama Wirahma",
                "email" => "rama-wirahma@ipdn.ac.id",
                "photo" => "defaultPhoto.jpeg",
                "password" => bcrypt("password"),
            ],
            [
                // "id" => uuid_create(4),
                "user_role" => $dataRole[1]['ROLE_ID'],
                "name" => "Admin Pustaka",
                "email" => "admin-pustaka@ipdn.ac.id",
                "photo" => "defaultPhoto.jpeg",
                "password" => bcrypt("password"),
            ],
        ];

        $dataMenu = [
            [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => "Seeder",
                'MENU_ICON' => "bi-house-fill",
                'MENU_DESCRIPTION' => "Menu Beranda Seeder",
                'MENU_URL' => "/",
                'MENU_POSITION' => "tautan",
            ],

            // Similaritas Admin
            [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => "Similaritas",
                'MENU_ICON' => "bi-percent",
                'MENU_DESCRIPTION' => "Menu Simiilaritas Admin",
                'MENU_URL' => "admin-similaritas",
                'MENU_POSITION' => "sidebar",
            ],

            // Similaritas Praja
            [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => "Similaritas",
                'MENU_ICON' => "bi-percent",
                'MENU_DESCRIPTION' => "Menu Simiilaritas Praja",
                'MENU_URL' => "praja-similaritas",
                'MENU_POSITION' => "sidebar",
            ],

            // Bebas Pinjaman Admin
            [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => "Bebas Pinjaman",
                'MENU_ICON' => "bi-journal-bookmark-fill",
                'MENU_DESCRIPTION' => "Menu Bebas Pinjaman Admin",
                'MENU_URL' => "admin-bebasPinjaman",
                'MENU_POSITION' => "sidebar",
            ],

            // Bebas Pinjaman Praja
            [
                'MENU_ID' => uuid_create(4),
                'MENU_NAME' => "Bebas Pinjaman",
                'MENU_ICON' => "bi-journal-bookmark-fill",
                'MENU_DESCRIPTION' => "Menu Bebas Pinjaman Praja",
                'MENU_URL' => "praja-bebasPinjaman",
                'MENU_POSITION' => "sidebar",
            ],


        ];

        $dataPivotMenu = [
            // Beranda
            [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_MENU' => $dataMenu[0]['MENU_ID'],
                'PIVOT_ROLE' => $dataRole[0]['ROLE_ID'],
                'PIVOT_DESCRIPTION' => "Assign Beranda untuk super admin",
            ],

            [
                'PIVOT_ID' => uuid_create(4),
                'PIVOT_MENU' => $dataMenu[0]['MENU_ID'],
                'PIVOT_ROLE' => $dataRole[1]['ROLE_ID'],
                'PIVOT_DESCRIPTION' => "Assign Beranda untuk admin",
            ],

        ];

        $dataAkses = [
            //
            [
                'ACCESS_ID' => uuid_create(4),
                'ACCESS_MENU' => $dataPivotMenu[0]['PIVOT_ID'],
                'ACCESS_CREATE' => random_int(0, 1),
                'ACCESS_READ' => random_int(0, 1),
                'ACCESS_UPDATE' => random_int(0, 1),
                'ACCESS_DELETE' => random_int(0, 1),
                'ACCESS_RESTORE' => random_int(0, 1),
                'ACCESS_DESTROY' => random_int(0, 1),
                'ACCESS_DETAIL' => random_int(0, 1),
                'ACCESS_VIEW' => random_int(0, 1),
            ],
            [
                'ACCESS_ID' => uuid_create(4),
                'ACCESS_MENU' => $dataPivotMenu[1]['PIVOT_ID'],
                'ACCESS_CREATE' => random_int(0, 1),
                'ACCESS_READ' => random_int(0, 1),
                'ACCESS_UPDATE' => random_int(0, 1),
                'ACCESS_DELETE' => random_int(0, 1),
                'ACCESS_RESTORE' => random_int(0, 1),
                'ACCESS_DESTROY' => random_int(0, 1),
                'ACCESS_DETAIL' => random_int(0, 1),
                'ACCESS_VIEW' => random_int(0, 1),
            ],
        ];

        Role::insert($dataRole);
        User::insert($dataUser);
        Menu::insert($dataMenu);
        pivotMenu::insert($dataPivotMenu);
        Akses::insert($dataAkses);

    }
}
