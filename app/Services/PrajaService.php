<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Exception;
use function PHPUnit\Framework\returnArgument;

class PrajaService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.praja_api.url');
        $this->token = config('services.praja_api.token');
    }


    // Maca data praja
    public function getPraja($npp = null)
    {
        try {

            $response = Http::get($this->baseUrl . 'praja');
            // $response = json_decode(file_get_contents($url));

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception('API request failed: ' . $response->body());

        } catch (Exception $e) {
            logger()->error('Mahasiswa API Error: ' . $e->getMessage());
            return null;
        }
    }


    // Milarian data praja dumasar kana npp
    public function getDetailPraja($npp = null)
    {
        try {
            $url = $this->baseUrl . 'praja';
            if ($npp) {
                $url .= '?npp=' . $npp;
            }

            $response = Http::timeout(30)
                ->get($url);

            if ($response->successful()) {
                $response->json();
                return $response["data"][0];
            }

            throw new Exception('API request failed: ' . $response->body());

        } catch (Exception $e) {
            logger()->error('Mahasiswa API Error: ' . $e->getMessage());
            return null;
        }
    }


    // Fungsi kanggo ngarobih nami fakultas janten inisial fakultas
    public function getInisialFakultas($fakultas)
    {
        switch ($fakultas) {
            case 'POLITIK PEMERINTAHAN':
                # code...
                $fakultas = "FPP";
                break;

            case 'MANAJEMEN PEMERINTAHAN':
                # code...
                $fakultas = "FMP";
                break;

            case 'PERLINDUNGAN MASYARAKAT':
                # code...
                $fakultas = "FPM";
                break;

            default:
                # code...
                break;
        }

        return $fakultas;
    }



    // Fungsi kanggo ngarobih inisial fakultas janten nami fakultas
    public function getFakultasName($fakultas)
    {
        switch ($fakultas) {
            case 'FPP':
                # code...
                $fakultas = "POLITIK PEMERINTAHAN";
                break;

            case 'FMP':
                # code...
                $fakultas = "MANAJEMEN PEMERINTAHAN";
                break;

            case 'FPM':
                # code...
                $fakultas = "PERLINDUNGAN MASYARAKAT";
                break;

            default:
                # code...
                break;
        }

        return $fakultas;
    }


    // Modal Get Detail Praja
    public function getModalDetailPraja($npp)
    {
        // Nyandak data praja ti API
        $praja = $this->getDetailPraja($npp);

        // Milari nomor HP Praja
        $userPraja = User::where('email', $npp . '@praja.ipdn.ac.id')->first();
        $praja['NOMOR_PONSEL'] = $userPraja->nomor_ponsel;


        // Tanggal Lahir
        $praja['TANGGAL_LAHIR'] = Carbon::createFromFormat("Y-m-d", $praja["TANGGAL_LAHIR"])->format("d M Y");


        // Jenis Kelamin
        $praja['JENIS_KELAMIN'] = $praja['JENIS_KELAMIN'] == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI';

        return $praja;
    }
}
