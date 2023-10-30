<?php

namespace App\Livewire\Admin\Similaritas;

use App\Models\User;
use Livewire\Component;

class Table extends Component
{
    public $buttonCreate;
    public $buttonApprove;


    public function render()
    {
        $similaritas = User::latest()->paginate();
        return view('livewire.admin.similaritas.table', [
            'similaritas' => $similaritas
        ]);
    }
}
