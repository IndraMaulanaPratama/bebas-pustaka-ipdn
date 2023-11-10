{{-- Card kanggo formulir tambih data --}}
<x-admin.components.modal.modal id='formCreateMenu'>
    <x-admin.components.modal.header id='formCreateMenu' title="Form tambah data menu" />

    <div class="modal-body">
        <form wire:submit={{ $actionName }} class="form row g-3">

            <input type="hidden" class="form-control" wire:model.live='id' required='required' />

            {{-- Baris kanggo input menu sareng icon --}}
            <div class="row g-2">
                <div class="col-6">
                    {{-- Input Menu Name --}}
                    <x-admin.components.form.input name='menu' placeholder='Nama Menu' />
                </div>

                <div class="col-6">
                    {{-- Input Icon Menu --}}
                    <x-admin.components.form.input name='icon' placeholder='Icon Menu' />
                    <small>
                        <a href="https://icons.getbootstrap.com/" target="_blank">Lihat referensi icon</a>
                    </small>
                </div>
            </div>

            {{-- Baris kanggo input url sareng posisi --}}
            <div class="row g-2">
                <div class="col-6">
                    {{-- Input Url --}}
                    @php
                        $host = env('APP_URL') . '/'; // Nyandak alamat aplikasi
                    @endphp
                    <x-admin.components.form.input-group name='url' :textGroup="$host" />
                    <span class="badge border-light border-1 text-black-50">Gambaran url aplikasi</span>

                </div>

                <div class="col-6">
                    {{-- Input Posisi Menu --}}
                    <x-admin.components.form.select name='position' required='required' placeholder='Posisi Menu'>
                        <option value="tautan">Tautan Navigasi</option>
                        <option value='navbar'>Navbar</option>
                        <option value="sidebar">Sidebar</option>
                    </x-admin.components.form.select>

                </div>
            </div>


            {{-- Input Description --}}
            <x-admin.components.form.textarea name='description' placeholder='Deskripsi Menu' tinggi='100' />



            <div class="col-6">
                <x-admin.components.form.button type="submit" color="primary" text="Simpan" />
                <x-admin.components.form.button-reset functionName='resetForm' />
            </div>

            <div class="col-4">
            </div>

        </form>
    </div>
</x-admin.components.modal.modal>
