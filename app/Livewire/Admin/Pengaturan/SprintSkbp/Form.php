<?php

namespace App\Livewire\Admin\Pengaturan\SprintSkbp;

use App\Models\SettingApps;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $sprint;
    public $timestamp;

    #[On("data-rejected"), On("failed-updating-data"), On("data-updated")]
    public function placeholder()
    {
        return view("components.admin.components.spinner.loading");
    }


    public function updateSkbp()
    {
        $name = $this->timestamp . '-' . str_replace(" ", "", $this->sprint->getClientOriginalName());
        $data = [
            'SETTING_SPRINT' => $name,
        ];

        try {
            // Upload file tanda tangan
            $this->sprint->storeAs('dokumen', $name, 'public');

            // Update database
            SettingApps::where('SETTING_ID', 1)->update($data);

            $this->dispatch("data-updated", "Dokumen Surat Perintah SKBP berhasil diperbaharui");
            $this->reset();

        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }
    }


    public function mount()
    {
        $this->timestamp = Carbon::now('Asia/Jakarta')->timestamp;
    }

    public function render()
    {
        return view('livewire.admin.pengaturan.sprint-skbp.form');
    }
}
