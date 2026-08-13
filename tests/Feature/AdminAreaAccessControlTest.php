<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Test regresi kaamanan pikeun sadaya kaca "Admin Area" (Manajemen Role,
 * Manajemen Menu, Manajemen Pengguna, Manajemen Akses, jeung Pengaturan
 * Website). Mekanisme lama (middleware 'access' / PembatasanAksesMenu)
 * ngan nyumputkeun link menu-na di sidebar tapi TETEP ngijinkeun sadaya
 * role muka URL-na langsung. Ku kituna unggal component ieu ayeuna nyieun
 * pamariksaan sorangan (mount()), nyoco pola nu geus dipake di
 * Riwayat Aktivitas (tempo RiwayatAktivitasTest.php).
 */
class AdminAreaAccessControlTest extends TestCase
{
    use DatabaseTransactions;

    private function createUserWithRole(string $roleName): User
    {
        $roleId = (string) Str::uuid();
        Role::create([
            'ROLE_ID' => $roleId,
            'ROLE_NAME' => $roleName,
        ]);

        return User::create([
            'name' => 'Contoh ' . $roleName,
            'email' => 'user.' . Str::random(8) . '@ipdn.ac.id',
            'password' => bcrypt('rahasia'),
            'user_role' => $roleId,
        ]);
    }

    public static function adminAreaRoutes(): array
    {
        return [
            'Manajemen Role' => ['/role'],
            'Manajemen Menu' => ['/menu'],
            'Manajemen Pengguna' => ['/users'],
            'Manajemen Akses' => ['/assign'],
            'Pengaturan Website' => ['/setting'],
            'Pengaturan Data Kepala Unit' => ['/pengaturan/data-kepala-unit'],
            'Pengaturan Sprint SKBP' => ['/pengaturan/sprint'],
            'Pengaturan Formulir Survei Praja' => ['/pengaturan/formulir/survei-praja'],
            'Pengaturan Formulir Konten Literasi' => ['/pengaturan/formulir/konten-literasi'],
            'Pengaturan Formulir Unggah Repository' => ['/pengaturan/formulir/unggah-repository'],
        ];
    }

    /** @dataProvider adminAreaRoutes */
    public function test_super_admin_can_access_the_admin_area_page(string $url): void
    {
        $admin = $this->createUserWithRole('Super Admin');

        $response = $this->actingAs($admin)->get($url);

        $response->assertOk();
    }

    /** @dataProvider adminAreaRoutes */
    public function test_admin_pustaka_can_access_the_admin_area_page(string $url): void
    {
        $admin = $this->createUserWithRole('Admin Pustaka');

        $response = $this->actingAs($admin)->get($url);

        $response->assertOk();
    }

    /**
     * Regresi keamanan utama: sabelum diperbaiki, role naon wae bisa muka
     * URL ieu langsung sanajan teu katembong di sidebar-na. Ayeuna kudu
     * balik 404, sarua jeung kalakuan Riwayat Aktivitas.
     *
     * @dataProvider adminAreaRoutes
     */
    public function test_a_non_admin_role_cannot_open_the_admin_area_page_via_direct_url(string $url): void
    {
        $praja = $this->createUserWithRole('Praja Utama');

        $response = $this->actingAs($praja)->get($url);

        $response->assertNotFound();
    }
}
