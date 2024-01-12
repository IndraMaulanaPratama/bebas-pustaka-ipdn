<?php

namespace App\Livewire\Admin\Pengaturan\SprintSkbp;

use App\Models\SettingApps;
use Livewire\Component;

class PreviewSurat extends Component
{
    public function render()
    {
        $sprint = SettingApps::where('SETTING_ID', 1)->first();

        return view('livewire.admin.pengaturan.sprint-skbp.preview-surat', ['sprint' => $sprint->SETTING_SPRINT]);
    }
}
