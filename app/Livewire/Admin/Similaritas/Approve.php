<?php

namespace App\Livewire\Admin\Similaritas;

use App\Models\Similaritas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Approve extends Component
{
    public $inputSimilaritas, $inputSmallWord, $id;
    public $switchBibliografi = false, $switchSmallWord = false, $switchQuotes = false;



    public function resetForm()
    {
        $this->reset();
    }



    public function generateNomorSurat($fakultas)
    {
        if ($fakultas == "POLITIK PEMERINTAHAN") {
            $fakultas = "FPP";
        } elseif ($fakultas == "MANAJEMEN PEMERINTAHAN") {
            $fakultas = "FMP";
        } elseif ($fakultas == "PERLINDUNGAN MASYARAKAT") {
            $fakultas = "FPM";
        }

        $jumlahData = Similaritas::whereNotNull('SIMILARITAS_APPROVED')->count();
        $nomor = sprintf("%04s", abs($jumlahData + 1));
        $tahun = Carbon::now('Asia/Jakarta')->format("Y");
        return "000.5.2.4/BPS-" . $fakultas . "." . $nomor . "/IPDN.21/" . $tahun;
    }


    #[On("selected-data")]
    public function getIdSimilaritas($id)
    {
        $this->id = $id;
    }



    public function approveData()
    {
        $officer = Auth::user()->id;
        $nomorSurat = $this->generateNomorSurat('POLITIK PEMERINTAHAN');

        try {
            $data = [
                'SIMILARITAS_NUMBER' => $nomorSurat,
                "SIMILARITAS_OFFICER" => $officer,
                "SIMILARITAS_VALUE" => $this->inputSimilaritas,
                "SIMILARITAS_BIBLIOGRAFI" => $this->switchBibliografi,
                "SIMILARITAS_SMALL_WORD" => $this->switchSmallWord,
                "SIMILARITAS_SMALL_WORD_COUNT" => $this->inputSmallWord,
                "SIMILARITAS_QUOTE" => $this->switchQuotes,
                "SIMILARITAS_STATUS" => "Disetujui",
                "SIMILARITAS_APPROVED" => Carbon::now("Asia/Jakarta")->format("Y-m-d H:i:s"),
            ];

            Similaritas::where("SIMILARITAS_ID", $this->id)->update($data);
            $this->dispatch("data-updated", "Pengajuan similaritas berhasil disetujui");
            $this->reset();
        } catch (\Throwable $th) {
            $this->dispatch("failed-updating-data", $th->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.admin.similaritas.approve');
    }
}
