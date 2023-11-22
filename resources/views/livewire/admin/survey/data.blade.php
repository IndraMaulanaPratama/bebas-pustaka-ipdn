{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

<div class="row">
    <x-admin.components.card.card small=12 medium=6 size=6 title="Data Formulir Survey" titleSpan="Status Aktif">

        <p>Untuk membuka formulir survey, silahkan klik tombol dibawah ini:</p>
        <a href="{{ $data->SURVEY_URL }}" class="btn btn-outline-primary btn-sm" target="blank">Buka Formulir Survey</a>

        &nbsp; Atau

        <button class="btn btn-link btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#formUpdate"
            aria-expanded="false" aria-controls="formUpdate">
            Ubah halaman survey
        </button>

    </x-admin.components.card.card>


    <div class="collapse col-sm-12 col-md-6 col-lg-6" id="formUpdate" wire:ignore>
        <x-admin.components.card.card title="Ubah formulir Survey" titleSpan="Perubahan Data">

            <form wire:submit='updateSurvey' method="POST">
                <div class="row g-2">
                    <div>
                        <x-admin.components.form.input name="inputUrl"
                            placeholder="Alamat URL halaman Formulir Survey" />
                    </div>

                    <div>
                        <x-admin.components.form.button type="submit" color="primary" size='sm' text="Simpan" />

                        <a class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" href="#formUpdate"
                            role="button" aria-expanded="false" aria-controls="collapseExample" wire:click='resetForm'>
                            Batalkan
                        </a>
                    </div>
                </div>
            </form>

        </x-admin.components.card.card>
    </div>

</div>
