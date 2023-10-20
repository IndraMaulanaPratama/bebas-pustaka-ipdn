<?php

namespace Database\Seeders;

use App\Models\Akses;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        Role::create($dataRole);
        User::create($dataUser);
    }
}
