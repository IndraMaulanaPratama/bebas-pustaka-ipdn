<?php

namespace Tests\Feature;

use App\Livewire\Admin\Profile\Update;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test pikeun modul "Profil Saya" — fitur nu ngamungkinkeun sadaya role
 * (Super Admin, Admin Pustaka, Praja Utama) ngarobih foto jeung kata sandi
 * dirina sorangan ti dropdown navbar.
 *
 * Storage::fake('public') sengaja dipaké di unggal test nu ngupload file
 * supados teu nyeuseup/ngahapus file produksi nu tos aya di
 * storage/app/public/foto_pegawai (fake disk misah ti disk aslina).
 */
class ProfileSelfServiceTest extends TestCase
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
            'password' => bcrypt('rahasia-lama'),
            'user_role' => $roleId,
        ]);
    }

    public static function allRoles(): array
    {
        return [
            'Super Admin' => ['Super Admin'],
            'Admin Pustaka' => ['Admin Pustaka'],
            'Praja Utama' => ['Praja Utama'],
        ];
    }

    /** @dataProvider allRoles */
    public function test_any_authenticated_role_can_open_the_profile_component(string $roleName): void
    {
        $user = $this->createUserWithRole($roleName);

        Livewire::actingAs($user)
            ->test(Update::class)
            ->assertOk();
    }

    public function test_uploading_a_valid_image_updates_the_users_photo_and_removes_the_old_one(): void
    {
        Storage::fake('public');

        $user = $this->createUserWithRole('Praja Utama');

        // Simulasikeun user ieu geus kagungan foto lami kalayan ekstensi
        // nu bénten (jpg), supados bisa dipariksa yén file lami ieu
        // dihapus sanggeus foto anyar (png) kasimpen.
        Storage::disk('public')->put('foto_pegawai/profile_' . $user->id . '.jpg', 'isi-lami');

        Livewire::actingAs($user)
            ->test(Update::class)
            ->set('photo', UploadedFile::fake()->image('foto-baru.jpg', 200, 200))
            ->call('updateProfile')
            ->assertHasNoErrors()
            // Modal ini wire:ignore, jadi tutup-modal & notifikasi sukses/gagal
            // ditanganan JS di admin-navbar.blade.php via event ini (lihat
            // catatan di Update::updateProfile()) — dikonfirmasi di sini
            // supaya kontrak antara PHP & JS ini kejaga oleh test.
            ->assertDispatched('profile-updated');

        $user->refresh();

        $this->assertSame('profile_' . $user->id . '.png', $user->photo);
        Storage::disk('public')->assertExists('foto_pegawai/profile_' . $user->id . '.png');
        Storage::disk('public')->assertMissing('foto_pegawai/profile_' . $user->id . '.jpg');
    }

    public function test_a_file_that_only_pretends_to_be_an_image_is_rejected(): void
    {
        Storage::fake('public');

        $user = $this->createUserWithRole('Praja Utama');
        $originalPhoto = $user->photo;

        // File ieu "nyamun" jadi JPEG sah (nami .jpg + MIME dipalsukeun
        // 'image/jpeg', persis kawas serangan upload nu sabenerna), tapi
        // eusina lain data gambar — nu kudu ditolak ku SecureImageUploader
        // sanggeus validasi Livewire-level (mimes/image) kaliwat.
        $disguisedFile = UploadedFile::fake()->create('shell.jpg', 10, 'image/jpeg');

        Livewire::actingAs($user)
            ->test(Update::class)
            ->set('photo', $disguisedFile)
            ->call('updateProfile')
            ->assertDispatched('profile-update-failed');

        $user->refresh();

        $this->assertSame($originalPhoto, $user->photo);
        Storage::disk('public')->assertDirectoryEmpty('foto_pegawai');
    }

    public function test_password_can_be_changed_and_used_to_login_afterwards(): void
    {
        $user = $this->createUserWithRole('Admin Pustaka');

        Livewire::actingAs($user)
            ->test(Update::class)
            ->set('new_password', 'kata-sandi-baru')
            ->set('confirm_password', 'kata-sandi-baru')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertTrue(Hash::check('kata-sandi-baru', $user->password));
        $this->assertTrue(Hash::check('kata-sandi-baru', $user->fresh()->password));
    }

    public function test_password_confirmation_mismatch_is_rejected_and_old_password_still_works(): void
    {
        $user = $this->createUserWithRole('Super Admin');

        Livewire::actingAs($user)
            ->test(Update::class)
            ->set('new_password', 'kata-sandi-baru')
            ->set('confirm_password', 'tidak-cocok')
            ->call('updateProfile')
            ->assertHasErrors(['confirm_password'])
            ->assertDispatched('profile-update-failed');

        $this->assertTrue(Hash::check('rahasia-lama', $user->fresh()->password));
    }

    public function test_submitting_without_photo_or_password_shows_a_helpful_message_and_changes_nothing(): void
    {
        $user = $this->createUserWithRole('Praja Utama');

        $component = Livewire::actingAs($user)
            ->test(Update::class)
            ->call('updateProfile')
            ->assertDispatched('profile-update-failed');

        $component->assertSet('errorMessage', 'Silakan pilih foto baru atau isi kata sandi baru terlebih dahulu.');
        $this->assertTrue(Hash::check('rahasia-lama', $user->fresh()->password));
    }

    public function test_changing_password_only_is_recorded_in_the_activity_log(): void
    {
        $user = $this->createUserWithRole('Praja Utama');

        Livewire::actingAs($user)
            ->test(Update::class)
            ->set('new_password', 'kata-sandi-baru')
            ->set('confirm_password', 'kata-sandi-baru')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('activity_logs', [
            'module' => 'Profil',
            'action' => 'update',
            'description' => 'Memperbaharui kata sandi sendiri',
        ]);
    }
}
