<x-admin.components.modal.modal id='exampleModal'>
    <x-admin.components.modal.header id='exampleModal' title="Form ubah data penggun" />


    <div class="modal-body">
        <form wire:submit='updateData' method="POST" enctype="multipart/form-data">
            <div class="form row g-3">
                <input type="hidden" wire:model.live='id' />

                {{-- Input Nama Lengkap --}}
                {{-- <x-admin.components.form.input name='id' placeholder='ID Pengguna' disabled='disabled' /> --}}

                {{-- Input Nama Lengkap --}}
                <x-admin.components.form.input name='name' placeholder='Nama Lengkap' />


                {{-- Input Email --}}
                <x-admin.components.form.input type='email' name='email' placeholder='Surat Elektronik' />


                {{-- Input Password --}}
                {{-- <x-admin.components.form.input type='password' name='password' placeholder='Kata Sandi' /> --}}

                {{-- Input Photo --}}
                <x-admin.components.form.file name='photo' id="iteration" placeholder="Foto Pegawai" />


                {{-- Input Tanda Tangan --}}
                <x-admin.components.form.file name='sign' id="iteration" placeholder="Tanda Tangan" />


                {{-- Input Role --}}
                <x-admin.components.form.select name='role' placeholder='Role Pegawai'>
                    @foreach ($data_role as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </x-admin.components.form.select>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click='resetForm' data-bs-dismiss="modal">
                    Batalkan
                </button>
                <button type="submit" class="btn btn-outline-primary"data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </form>
    </div>

</x-admin.components.modal.modal>
