<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\SecureImageUploader;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class Create extends Component
{
    use WithFileUploads;
    use WithPagination;


    // Inisialisasi variable mandatory
    public $title, $titleSpan, $actionName;
    public $id, $role;

    public $requiredPassword = "required";
    public $requiredFile = "required";

    /***
     * Ranah kanggo Validasi input form
     */

    #[Rule(["required", "string", "max:255"])]
    public $name;

    #[Rule(["string", "email:rfc,dns", "max:255", "unique:users,email"])]
    public $email;

    #[Rule(["string", "min:8", "max:255"])]
    public $password;

    #[Rule(["same:password"])]
    public $confirm_password;

    #[Rule('nullable|image|mimes:jpeg,jpg,png,webp|max:2048')]
    public $photo, $sign;



    /**
     * Fungsi kanggo mulangkeun kondisi form pendaptaran anggota
     */

    public function resetForm()
    {
        $this->reset();

        // Settingan card form-tambih users
        $this->title = 'Formulir Data Pengguna';
        $this->titleSpan = 'Tambah Data';
        $this->actionName = 'createData';

    }




    public function createData()
    {

        try {
            $timestamp = Carbon::now('Asia/Jakarta')->timestamp;
            $idUser = uuid_create(4); // <!-- Ngadamel id nu unik kanggo database

            // Ngadamel inisialisasi data kangga database user
            $data = [
                'id' => $idUser,
                'name' => $this->name,
                'email' => $this->email,
                'email_verified_at' => $timestamp,
                'password' => bcrypt($this->password),
                'photo' => 'defaultPhoto.png',
                'sign' => 'defaultSign.png',
                'user_role' => $this->role,
            ];

            if ($this->password == null) {
                unset($data['password']);
            }

            // Foto/tanda tangan disimpen ku SecureImageUploader: isi filena
            // dibaca ulang tur digambar ulang jadi PNG anyar (teu percaya
            // kana nami/ekstensi file asli ti client) sateuacan disimpen
            // kalayan nami deterministik dumasar id user (1 file per user).
            if ($this->photo != null) {
                $data['photo'] = SecureImageUploader::store($this->photo, 'foto_pegawai', 'profile_' . $idUser);
            }
            if ($this->sign != null) {
                $data['sign'] = SecureImageUploader::store($this->sign, 'tanda_tangan', 'sign_' . $idUser);
            }

            // Proses nyimpen data nu dikintun ka lebet database
            $user = User::create($data);

            // nyatet aktivitas nambihan pengguna enggal
            ActivityLogger::log('Pengguna', ActivityLogger::CREATE, 'Menambahkan pengguna baru: ' . $this->name, $user);

            // Ngintun sinyal ka komponen nu sanes, yen data tos rengse di simpen
            $this->dispatch('user-created', 'Pengguna baru berhasil ditambahkan');
            $this->resetForm();

        } catch (\Throwable $th) {
            $this->dispatch('failed-creating-user', $th->getMessage());
        }
    }




    public function updateData()
    {

        try {
            $timestamp = Carbon::now('Asia/Jakarta')->timestamp;
            // $photoName = $timestamp . '-' . $this->photo->getClientOriginalName(); // <!-- Maca nami poto
            // $signName = $timestamp . '-' . $this->sign->getClientOriginalName(); // <!-- Maca nami file tanda tangan

            // Ngadamel inisialisasi data kangga database user
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'email_verified_at' => $timestamp,
                'password' => bcrypt($this->password),
                'photo' => $this->photoName,
                'sign' => $this->signName,
                'user_role' => $this->role,
            ];


        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-user', $th->getMessage());
        }

    }



    /***
     * Fungsi kanggo ngarender tampilan aplikasi
     */
    public function render()
    {
        // Maca data role kanggo pilihan form pendaftaran
        $role = Role::query()->whereNot('ROLE_NAME', '=', 'Super Admin')->get([
            'ROLE_ID AS id',
            'ROLE_NAME AS name'
        ]);

        return view('livewire.admin.users.create', ['data_role' => $role]);
    }
}
