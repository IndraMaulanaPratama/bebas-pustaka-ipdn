<x-admin.components.modal.modal id='formCreateData'>
    <x-admin.components.modal.header id='formCreateData' title="Form tambah data pengguna" />

            <div class="modal-body">
                <form wire:submit='createData' method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="form row g-3">
                            <input type="hidden" wire:model.live='id' />


                            {{-- Input Nama Lengkap --}}
                            <x-admin.components.form.input name='name' placeholder='Nama Lengkap' required='required' />


                            {{-- Input Email --}}
                            <x-admin.components.form.input type='email' name='email' placeholder='Surat Elektronik'
                                required='required' />


                            {{-- Input Password --}}
                            <x-admin.components.form.input type='password' name='password' placeholder='Kata Sandi'
                                required='{{ $requiredPassword }}' />


                            {{-- Input Konfirmasi Password --}}
                            <x-admin.components.form.input type='password' name='confirm_password'
                                placeholder='Konfirmasi Kata Sandi' required='{{ $requiredPassword }}' />


                            {{-- Input Photo --}}
                            <x-admin.components.form.file name='photo' placeholder="Foto Pegawai" />


                            {{-- Input Tanda Tangan --}}
                            <x-admin.components.form.file name='sign' placeholder="Tanda Tangan" />


                            {{-- Input Role --}}
                            <x-admin.components.form.select name='role' placeholder='Role Pegawai'>
                                @foreach ($data_role as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </x-admin.components.form.select>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click='resetForm'
                            data-bs-dismiss="modal">
                            Batalkan
                        </button>
                        <button type="submit" class="btn btn-outline-primary"data-bs-dismiss="modal">
                            Simpan
                        </button>
                    </div>


                </form>

            </div>

</x-admin.components.modal.modal>
