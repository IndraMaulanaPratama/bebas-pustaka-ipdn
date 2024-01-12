<?php

namespace App\Livewire\Admin\Pengaturan\KepalaUnit;

use App\Models\SettingApps;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $nama_lengkap, $nip, $sign;
    public $timestamp;

    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }


    public function updateKepalaUnit()
    {
        $signName = $this->timestamp. '-' .str_replace(" ", "", $this->sign->getClientOriginalName());

        $data = [
            'SETTING_HEAD_OFFICE_NAME' => $this->nama_lengkap,
            'SETTING_HEAD_OFFICE_ID' => $this->nip,
            'SETTING_HEAD_OFFICE_SIGN' => $signName,
        ];

        try {
            // Upload file tanda tangan
            $this->sign->storeAs('tanda_tangan', str_replace(" ", "", $signName), 'public');

            SettingApps::where('SETTING_ID', 1)->update($data);

            $this->dispatch("data-updated", "Data Kepala Unit berhasil diperbaharui");
            // $this->reset();

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }

    }


    public function mount()
    {
        $data = SettingApps::first();
        // dd($data);

        $this->nama_lengkap = $data->SETTING_HEAD_OFFICE_NAME;
        $this->nip = $data->SETTING_HEAD_OFFICE_ID;
        $this->timestamp = Carbon::now('Asia/Jakarta')->timestamp;


    }


    public function render()
    {
        return view('livewire.admin.pengaturan.kepala-unit.form');
    }
}
