<div class="col-12">
    <x-admin.components.card.card size='8' :title="$title" :titleSpan="$titleSpan">

        <form wire:submit={{ $actionName }} class="form row g-3" enctype="multipart/form-data">

            {{-- Input Nama Lengkap --}}
            <x-admin.components.form.input name='name' placeholder='Nama Lengkap' required='required' />


            {{-- Input Email --}}
            <x-admin.components.form.input type='email' name='email' placeholder='Surat Elektronik'
                required='required' />


            {{-- Input Password --}}
            <x-admin.components.form.input type='password' name='password' placeholder='Kata Sandi'
                required='{{ $requiredPassword }}' />


            {{-- Input Konfirmasi Password --}}
            <x-admin.components.form.input type='password' name='confirm_password' placeholder='Konfirmasi Kata Sandi'
                required='{{ $requiredPassword }}' />


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


            {{-- Tombol Simpan dan Reset --}}
            <div class="col-12">
                <x-admin.components.form.button type='submit' color='primary' text='Simpan' />
                <x-admin.components.form.button-reset type='submit' color='primary' text='Reset'
                    functionName='resetForm' />
            </div>

        </form>
    </x-admin.components.card.card>



    {{-- Modal Update --}}

</div>
