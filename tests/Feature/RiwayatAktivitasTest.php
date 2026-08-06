<?php

namespace Tests\Feature;

use App\Livewire\Admin\RiwayatAktivitas\Table;
use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Test pikeun halaman "Riwayat Aktivitas": listing, filter, export Excel/PDF,
 * jeung pambatesan akses (mung Super Admin/Admin Pustaka nu meunang muka).
 */
class RiwayatAktivitasTest extends TestCase
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

    public function test_super_admin_can_access_the_riwayat_aktivitas_page(): void
    {
        $admin = $this->createUserWithRole('Super Admin');

        $response = $this->actingAs($admin)->get('/riwayat-aktivitas');

        $response->assertOk();
        $response->assertSee('Riwayat Aktivitas');
    }

    public function test_a_non_admin_role_cannot_open_the_riwayat_aktivitas_page(): void
    {
        // Regresi keamanan: middleware 'access' bawaan aplikasi ternyata ngijinkeun
        // sadaya role (lain ngan Super Admin/Admin Pustaka) muka route Admin Area
        // ngaliwatan URL langsung. Ku kituna komponen ieu nyieun pamariksaan
        // sorangan (mount()) sangkan halaman sensitif (jejak audit, alesan
        // panolakan, alamat IP) tetep aman sanajan aya nu coba buka URL-na langsung.
        $praja = $this->createUserWithRole('Praja Utama');

        $response = $this->actingAs($praja)->get('/riwayat-aktivitas');

        $response->assertNotFound();
    }

    public function test_filtering_by_module_only_returns_matching_activities(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Contoh A');
        ActivityLogger::log('Menu', ActivityLogger::CREATE, 'Menambahkan menu baru: Contoh B');

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->set('filterModule', 'Role')
            ->assertSee('Menambahkan role baru: Contoh A')
            ->assertDontSee('Menambahkan menu baru: Contoh B');
    }

    public function test_filtering_by_action_only_returns_matching_activities(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Pinjaman Perpustakaan Pusat', ActivityLogger::APPROVE, 'Menyetujui pengajuan id praja 30.9999');
        ActivityLogger::log('Pinjaman Perpustakaan Pusat', ActivityLogger::REJECT, 'Menolak pengajuan id praja 30.8888. Alasan: contoh');

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->set('filterAction', ActivityLogger::REJECT)
            ->assertSee('Menolak pengajuan id praja 30.8888')
            ->assertDontSee('Menyetujui pengajuan id praja 30.9999');
    }

    public function test_search_keyword_matches_description_or_user_name(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Similaritas', ActivityLogger::SUBMIT, 'Mengajukan similaritas id praja 32.0749');
        ActivityLogger::log('Similaritas', ActivityLogger::SUBMIT, 'Mengajukan similaritas id praja 30.1111');

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->set('search', '32.0749')
            ->assertSee('32.0749')
            ->assertDontSee('30.1111');
    }

    public function test_export_excel_runs_successfully_and_logs_the_export_itself(): void
    {
        Excel::fake();

        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Contoh Export');

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->call('exportExcel');

        $this->assertDatabaseHas('activity_logs', [
            'module' => 'Riwayat Aktivitas',
            'action' => 'export',
        ]);
    }

    public function test_export_pdf_runs_successfully_and_logs_the_export_itself(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Contoh Export PDF');

        $response = Livewire::actingAs($admin)
            ->test(Table::class)
            ->call('exportPdf');

        $response->assertStatus(200);

        $this->assertDatabaseHas('activity_logs', [
            'module' => 'Riwayat Aktivitas',
            'action' => 'export',
        ]);
    }

    public function test_rejection_reason_is_visible_through_the_activity_properties(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        $log = ActivityLogger::log(
            'Pinjaman Perpustakaan Pusat',
            ActivityLogger::REJECT,
            'Menolak pengajuan pinjaman pustaka id praja 30.7777. Alasan: Berkas tidak lengkap',
            null,
            ['alasan_penolakan' => 'Berkas tidak lengkap']
        );

        $this->assertSame('Berkas tidak lengkap', $log->properties['alasan_penolakan']);

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->assertSee('Berkas tidak lengkap');
    }

    public function test_per_page_option_controls_how_many_rows_are_paginated(): void
    {
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        // 12 log anyar ieu otomatis jadi 12 log PANGANYARNA di sakabéh tabel
        // (nu séjén geus aya ti saméméhna), jadi bisa dipaké pikeun mastikeun
        // paginasi: upami perPage=10, log pangkolotna kudu murag ka kaca 2
        // (teu katembong di kaca 1). Token dijieun unik/teu tumpang tindih
        // sasama (lain ngan angka 1..12) supados teu kabaca sabagean ku
        // assertDontSee (misalna "Halaman 1" bakal cocog ka jero "Halaman 10").
        $tokens = [];
        for ($i = 1; $i <= 12; $i++) {
            $tokens[$i] = 'Token' . Str::random(10);
            ActivityLogger::log('Role', ActivityLogger::CREATE, "Menambahkan role baru: {$tokens[$i]}");
        }

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->set('perPage', 10)
            ->assertDontSee($tokens[1])
            ->set('perPage', 50)
            ->assertSee($tokens[1]);
    }

    public function test_detail_button_is_available_even_when_there_are_no_extra_properties(): void
    {
        // Regresi UI: tombol Detail sebelumnya ngan mucul upami $log->properties
        // teu kosong, padahal alamat IP jeung info parangkat/browser SALALAWASNA
        // aya keur unggal log — ku kituna tombol Detail kudu tetep bisa dipencet
        // sanajan teu aya "properties" tambihan.
        $admin = $this->createUserWithRole('Super Admin');
        Auth::login($admin);

        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Tanpa Properti');

        Livewire::actingAs($admin)
            ->test(Table::class)
            ->assertSee('Informasi Teknis');
    }
}
