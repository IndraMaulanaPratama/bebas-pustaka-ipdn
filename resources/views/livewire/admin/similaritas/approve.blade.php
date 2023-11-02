<x-admin.components.modal.modal id='formApprove'>
    <x-admin.components.modal.header id='formApprove' title="Form approval similaritas praja" />

    <form wire:submit='approveData' method="POST">

        <div class="row g-2 p-2">
            &nbsp;

            <x-admin.components.form.input name='inputSimilaritas' placeholder='Tingkat Similaritas' />

            <div class="col-6">
                {{-- Switch Access Create --}}
                <x-admin.components.form.switch name="switchBibliografi" label="Data Bibliografi" col='8' />

                {{-- Switch Access Create --}}
                <x-admin.components.form.switch name="switchSmallWord" label="Small Word" col='8' />

                {{-- Switch Access Create --}}
                <x-admin.components.form.switch name="switchQuotes" label="Quote Materials" col='8' />

            </div>
            <div class="col-6">
                <div class="row mb-2">
                    <div class="col-8">&nbsp;</div>
                </div>

                <x-admin.components.form.input name='inputSmallWord' placeholder='Ketentuan Small Word' />

            </div>


            {{-- Tombol Reset sareng Submit --}}
            <div class="modal-footer">
                {{-- Tombol Reset / Cancel --}}
                <button type="button" wire:click='resetForm' class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batalkan
                </button>

                {{-- Tombol Simpan / Submit --}}
                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>
        </div>
    </form>

</x-admin.components.modal.modal>
