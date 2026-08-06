<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard\RecentActivity;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test pikeun fitur log activity: nyimpen jejak aktivitas (login, tambah/ubah/hapus
 * data, pengajuan, approve/reject, cetak, export, dll) sarta nembongkeun na deui
 * di widget "Aktivitas Terbaru" dashboard admin.
 *
 * Nganggo DatabaseTransactions (BUKAN RefreshDatabase) supados teu ngarobih/ngahapus
 * skema atawa data nu geus aya di database dev — sadaya parobahan di jero test bakal
 * di-rollback otomatis sanggeus unggal test réngsé.
 */
class ActivityLogTest extends TestCase
{
    use DatabaseTransactions;

    private function createUser(string $roleName = 'Test Role'): User
    {
        // Catetan: model Role teu nyetel `$incrementing = false` sanajan
        // primary key-na string/UUID, nu ngabalukarkeun Eloquent numpukeun
        // deui $role->ROLE_ID jadi 0 di jero memory sanggeus create() (id
        // di database-na sorangan tetep bener). Ku kituna di dieu ROLE_ID
        // diteangan deui langsung tina variabel $roleId, lain tina attribute
        // hasil create() supados teu kababawa ku bug éta.
        $roleId = (string) Str::uuid();
        Role::create([
            'ROLE_ID' => $roleId,
            'ROLE_NAME' => $roleName,
        ]);

        return User::create([
            'id' => null,
            'name' => 'Rama Wirahma',
            'email' => 'rama.' . Str::random(8) . '@ipdn.ac.id',
            'password' => bcrypt('rahasia'),
            'user_role' => $roleId,
        ]);
    }

    public function test_it_records_an_activity_log_entry_with_the_authenticated_user(): void
    {
        $user = $this->createUser();
        Auth::login($user);

        $log = ActivityLogger::log(
            'Pinjaman Perpustakaan Pusat',
            ActivityLogger::APPROVE,
            'Menyetujui pengajuan pinjaman pustaka id praja 30.1234'
        );

        $this->assertNotNull($log);
        $this->assertDatabaseHas('activity_logs', [
            'id' => $log->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'module' => 'Pinjaman Perpustakaan Pusat',
            'action' => 'approve',
            'description' => 'Menyetujui pengajuan pinjaman pustaka id praja 30.1234',
        ]);
    }

    public function test_activity_log_uses_a_non_sequential_uuid_as_its_primary_key(): void
    {
        $log = ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Contoh UUID');

        $this->assertNotNull($log);
        $this->assertTrue(Str::isUuid($log->id));
    }

    public function test_it_never_throws_when_subject_is_an_array_instead_of_a_model(): void
    {
        // Regresi: dulu $subject bertype-hint ketat `?Model`, jadi kalau ada
        // component ngirim array (misalna data event Livewire nu can di-refetch
        // jadi Model asli), PHP bakal ngalungkeun TypeError PAS proses tolak
        // pengajuan — status pengajuan kaburu robih di database tapi log-na
        // gagal kacatet sarta pesen sukses ka user teu kaluar. $subject ayeuna
        // kudu nampi naon wae tanpa nyababkeun error.
        $log = ActivityLogger::log(
            'Pinjaman Perpustakaan Pusat',
            ActivityLogger::REJECT,
            'Menolak pengajuan pinjaman pustaka id praja 30.1234. Alasan: Berkas tidak lengkap',
            ['PUSTAKA_ID' => 'contoh-id', 'PUSTAKA_PRAJA' => '30.1234'],
            ['alasan_penolakan' => 'Berkas tidak lengkap']
        );

        $this->assertNotNull($log);
        $this->assertNull($log->subject_type);
        $this->assertNull($log->subject_id);
        $this->assertSame('Berkas tidak lengkap', $log->properties['alasan_penolakan']);
        $this->assertStringContainsString('Alasan: Berkas tidak lengkap', $log->description);
    }

    public function test_it_still_records_an_entry_when_there_is_no_authenticated_user(): void
    {
        Auth::logout();

        $log = ActivityLogger::logAs(
            'orang.tidak.dikenal@ipdn.ac.id',
            'Autentikasi',
            ActivityLogger::LOGIN,
            'Percobaan login gagal (orang.tidak.dikenal@ipdn.ac.id)'
        );

        $this->assertNotNull($log);
        $this->assertDatabaseHas('activity_logs', [
            'id' => $log->id,
            'user_id' => null,
            'user_name' => 'orang.tidak.dikenal@ipdn.ac.id',
            'action' => 'login',
        ]);
    }

    public function test_it_falls_back_to_a_default_color_and_icon_for_an_unrecognized_action(): void
    {
        $log = ActivityLog::create([
            'module' => 'Modul Uji Coba',
            'action' => 'aksi-tidak-dikenal',
            'description' => 'Aktivitas contoh nu action-na teu kadaptar',
        ]);

        $this->assertSame('muted', $log->action_color);
        $this->assertSame('bi-circle-fill', $log->action_icon);
    }

    public function test_perangkat_label_translates_common_user_agents_into_plain_language(): void
    {
        $chrome = ActivityLog::create([
            'module' => 'Uji Coba',
            'action' => 'login',
            'description' => 'contoh',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
        ]);
        $this->assertSame('Google Chrome di Windows', $chrome->perangkat_label);

        $iphone = ActivityLog::create([
            'module' => 'Uji Coba',
            'action' => 'login',
            'description' => 'contoh',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.5 Mobile/15E148 Safari/604.1',
        ]);
        $this->assertSame('Safari di iOS', $iphone->perangkat_label);

        $kosong = ActivityLog::create([
            'module' => 'Uji Coba',
            'action' => 'login',
            'description' => 'contoh',
        ]);
        $this->assertSame('Tidak diketahui', $kosong->perangkat_label);
    }

    public function test_recent_activity_widget_shows_the_newest_entry_first(): void
    {
        $user = $this->createUser();
        Auth::login($user);

        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Petugas Lama');
        $terbaru = ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Petugas Terbaru');

        Livewire::test(RecentActivity::class)
            ->assertSeeInOrder([
                $terbaru->description,
                'Menambahkan role baru: Petugas Lama',
            ]);
    }

    public function test_recent_activity_widget_shows_a_friendly_empty_state(): void
    {
        // Sengaja dikosongkeun heula di jero transaksi test ieu wungkul
        // (bakal di-rollback otomatis, data asli di database dev teu kapangaruhan).
        ActivityLog::query()->delete();

        Livewire::test(RecentActivity::class)
            ->assertSee('Belum aya aktivitas nu kacatet.');
    }

    public function test_dashboard_page_renders_the_recent_activity_widget_for_a_logged_in_admin(): void
    {
        $user = $this->createUser();
        ActivityLogger::log('Role', ActivityLogger::CREATE, 'Menambahkan role baru: Contoh Role Dashboard');

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertSee('Aktivitas Terbaru');
        $response->assertSee('Menambahkan role baru: Contoh Role Dashboard');
    }
}
