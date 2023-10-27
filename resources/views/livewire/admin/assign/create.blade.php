<x-admin.components.modal.modal id='formCreateAssign'>
    <x-admin.components.modal.header id='formCreateAssign' title="Form tambah data assign" />

    <form wire:submit='createData' method="POST">

        <div class="row g-2 p-2">
            &nbsp;

            {{-- Select Role --}}
            <x-admin.components.form.select name='selectRole' placeholder="Pilih Role">
                <option></option>
                @foreach ($role as $item)
                    <option value="{{ $item->ROLE_ID }}">{{ $item->ROLE_NAME }}</option>
                @endforeach
            </x-admin.components.form.select>

            {{-- Select Menu --}}
            <x-admin.components.form.select name='selectMenu' placeholder="Pilih menu">
                <option></option>
                @foreach ($menu as $item)
                    <option value="{{ $item->MENU_ID }}">{{ $item->MENU_NAME . ' ~ ' . $item->MENU_URL }}</option>
                @endforeach
            </x-admin.components.form.select>

            {{-- Textbox Description --}}
            <x-admin.components.form.textarea placeholder="Deskripsi data assign" name="description" />

            {{-- Akses Menu --}}
            <div class="row g-2 p-2">

                {{-- Akses Menu, Create, Read, Update, Delete --}}
                <div class="col-6">

                    {{-- Switch Access Create --}}
                    <x-admin.components.form.switch name="switchCreate" label="Tambah Data" />

                    {{-- Switch View Data --}}
                    <x-admin.components.form.switch name="switchRead" label="Lihat Data" />

                    {{-- Switch Update --}}
                    <x-admin.components.form.switch name="switchUpdate" label="Ubah Data" />

                    {{-- Switch Delete Data --}}
                    <x-admin.components.form.switch name="switchDelete" label="Hapus Data" />
                </div>

                {{-- Restore, Destroy, Detail, View --}}
                <div class="col-6">
                    {{-- Switch Restore Data --}}
                    <x-admin.components.form.switch name="switchRestore" label="Pulihkan Data" />

                    {{-- Switch Destroy Data --}}
                    <x-admin.components.form.switch name="switchDestroy" label="Hapus Permanen" />

                    {{-- Switch View Detail --}}
                    <x-admin.components.form.switch name="switchDetail" label="Lihat Detail" />

                    {{-- Switch Show View --}}
                    <x-admin.components.form.switch name="switchView" label="Buka Halaman" />
                </div>

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
