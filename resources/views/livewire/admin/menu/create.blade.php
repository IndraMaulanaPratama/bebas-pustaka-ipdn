<div class="col-4">
    <x-admin.components.card.card size=12 :title="$title" :titleSpan="$spanTitle">
        <form wire:submit={{ $actionName }} class="form row g-3">

            <input type="hidden" class="form-control" wire:model.live='id' required='required' />

            {{-- Input Menu Name --}}
            <x-admin.components.form.input name='menu' placeholder='Nama Menu' />

            {{-- Input Menu Name --}}
            <x-admin.components.form.input name='folder' placeholder='Folder Menu' />


            {{-- Input Description --}}
            <x-admin.components.form.textarea name='description' placeholder='Deskripsi Menu' />

            {{-- Input Url --}}
            @php
                $host = env('APP_URL');
            @endphp
            <x-admin.components.form.input-group name='url' :textGroup="$host" disabled='disabled' />

            <div class="col-6s">
                <button type="submit" class="btn btn-outline-primary">
                    <small>Simpan</small>
                </button>
                <button type="button" wire:click='resetForm' class="btn btn-outline-secondary">
                    <small>Reset</small>
                </button>

            </div>

            <div class="col-4">
            </div>

        </form>
    </x-admin.components.card.card>

</div>
