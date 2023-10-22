<div class="col-4">
    <x-admin.components.card.card size=12 :title="$title" :titleSpan="$spanTitle">
        <form wire:submit={{ $actionName }} class="form row g-3">

            <input type="hidden" class="form-control" wire:model.live='id' required='required' />

            {{-- Input Menu Name --}}
            <x-admin.components.form.input name='menu' placeholder='Nama Menu' />

            {{-- Input Menu Name --}}
            <x-admin.components.form.input name='icon' placeholder='Icon Menu' />
            <small><a href="https://icons.getbootstrap.com/" target="_blank">Lihat referensi icon menu</a></small>

            {{-- Input Description --}}
            <x-admin.components.form.textarea name='description' placeholder='Deskripsi Menu' />

            {{-- Input Url --}}
            @php
                $host = env('APP_URL'); // Nyandak alamat aplikasi
            @endphp
            <x-admin.components.form.input-group name='url' :textGroup="$host" disabled='disabled' />

            {{-- Input Posisi Menu --}}
            <x-admin.components.form.select name='position' required='required' placeholder='Posisi Menu'>
                <option value="tautan">Tautan Navigasi</option>
                <option value='navbar'>Navbar</option>
                <option value="sidebar">Sidebar</option>
            </x-admin.components.form.select>

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
