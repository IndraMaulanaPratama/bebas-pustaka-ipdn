<?php

namespace App\Livewire\Admin\Dashboard;

use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $date, $dateTime;

    public function mount()
    {
        $this->date = Carbon::now('Asia/Jakarta')->format('d M Y');
        $this->dateTime = Carbon::now('Asia/Jakarta');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
