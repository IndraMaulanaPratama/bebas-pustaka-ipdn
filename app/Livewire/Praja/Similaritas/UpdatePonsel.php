<?php

namespace App\Livewire\Praja\Similaritas;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class UpdatePonsel extends Component
{

    #[Rule(["required", "string", "max:14"])]
    public $inputNomor;


    public function resetForm()
    {
        $this->reset();
    }

    public function setPonsel()
    {
        try {
            User::where('id', Auth::user()->id)->update(["nomor_ponsel" => $this->inputNomor]);
            $this->dispatch('ponsel-updated', "Nomor ponsel anda sudah berhasil tersimpan");
        } catch (\Throwable $th) {
            $this->dispatch('failed-updating-ponsel', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.praja.similaritas.update-ponsel');
    }
}
