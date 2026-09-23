<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Penyimpanan file gambar (foto profil, tanda tangan, jrrd) nu aman.
 *
 * Sengaja teu percanten kana nami file/ekstensi nu dikintun ku client
 * (rawan dipalsukeun, misalna file PHP nu ngan diganti ekstensina jadi
 * .jpg). Isi file dibaca deui sacara real ku GD teras digambar ulang
 * jadi file PNG anyar sateuacan disimpen — supados byte naon wae di
 * luar data piksel gambar (misalna kode PHP nu ditempelkeun di tukangeun
 * file gambar, trik "polyglot") moal kabawa kasimpen kana disk.
 */
class SecureImageUploader
{
    private const ALLOWED_IMAGE_TYPES = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];

    /**
     * Nyimpen $file jadi hiji file PNG nu deterministik "{baseFilename}.png"
     * di jero "{directory}" dina disk $disk, ngagentos file lami kagungan
     * nami dasar nu sarua (ekstensi naon wae) upami aya — supados
     * tetep ngan 1 file keur 1 user/entitas.
     *
     * @return string Nami file nu kasimpen (basename wungkul).
     *
     * @throws \RuntimeException upami file lain gambar nu sah.
     */
    public static function store(UploadedFile $file, string $directory, string $baseFilename, string $disk = 'public'): string
    {
        $realPath = $file->getRealPath();

        $imageInfo = $realPath ? @getimagesize($realPath) : false;

        if ($imageInfo === false || !in_array($imageInfo[2], self::ALLOWED_IMAGE_TYPES, true)) {
            throw new \RuntimeException('File yang diunggah bukan gambar yang valid (hanya JPEG, PNG, atau WEBP yang diperbolehkan).');
        }

        $image = @imagecreatefromstring(file_get_contents($realPath));

        if ($image === false) {
            throw new \RuntimeException('Gagal membaca isi gambar. Silakan coba unggah ulang dengan file lain.');
        }

        imagesavealpha($image, true);

        ob_start();
        $encoded = imagepng($image);
        $binary = ob_get_clean();
        imagedestroy($image);

        if (!$encoded || $binary === false || $binary === '') {
            throw new \RuntimeException('Gagal memproses gambar. Silakan coba unggah ulang dengan file lain.');
        }

        $storage = Storage::disk($disk);

        // Hapus file lama milik nami dasar nu sarua (ekstensi naon wae)
        // supados teu nyésakeun file yatim tur tetep 1 file per user.
        foreach ($storage->files($directory) as $existingFile) {
            if (pathinfo($existingFile, PATHINFO_FILENAME) === $baseFilename) {
                $storage->delete($existingFile);
            }
        }

        $storedName = $baseFilename . '.png';

        $storage->put($directory . '/' . $storedName, $binary);

        return $storedName;
    }
}
