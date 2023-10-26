<div class="col-12">
    <x-admin.components.card.card size=12 title='List Menu' titleSpan='Status Aktif'>

        <div class="row g-4">
            <div class="col-12">

                {{-- Baris bagian search sareng tombol tambih data --}}
                <div class="row justify-content-between">

                    {{-- Tombol Tambah Data --}}
                    <div class="col-4">
                        {{-- Input Search --}}
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#formCreateMenu" wire:click='resetForm'>
                            <span class="bi bi-plus-circle" role="status" aria-hidden="true"></span>
                            Tambah Data
                        </button>
                    </div>

                    {{-- Input Pencarian Data --}}
                    <div class="col-4">
                        <x-admin.components.form.input size=12 type='text' name='search' placeholder='Cari Data' />
                    </div>
                </div>

                <table class="table table-responsive table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width=3%>#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">URL</th>
                            <th scope="col">Posisi</th>
                            <th scope="col" colspan="2" width=5%>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr wire:key='$i'>
                                <th scope="row"> {{ $loop->index + $data->firstItem() }} </th>
                                <td>{{ $item->MENU_NAME }}</td>
                                <td>{{ $item->MENU_DESCRIPTION }}</td>
                                <td>{{ $item->MENU_URL }}</td>
                                <td>{{ $item->MENU_POSITION }}</td>

                                {{-- Option Row --}}
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill"
                                        wire:click="updateMenu('{{ $item->MENU_ID }}')" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateMenu">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn rounded-pill btn-sm btn-outline-danger"
                                        wire:click='deleteMenu("{{ $item->MENU_ID }}")'
                                        wire:confirm='Anda yakin akan menghapus menu {{ $item->MENU_NAME }} ini?'>
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td> <!-- END Of OPTION ROW !-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <x-admin.tamplates.paginate.paginate :item="$data" />

    </x-admin.components.card.card>



    <!-- Modal Update Menu-->
    <x-admin.components.modal.modal id='formUpdateMenu'>

        {{-- Header Modal --}}
        <x-admin.components.modal.header id={{ $id }} title="Formulir ubah data menu" />

        <form wire:submit='updateData' method="POST">

            <div class="modal-body">
                <div class="row g-4">
                    <input type="hidden" class="form-control" wire:model.live='id' required='required' />

                    {{-- Input Menu Name --}}
                    <x-admin.components.form.input name='menu' placeholder='Nama Menu' />

                    {{-- Input Icon Menu --}}
                    <x-admin.components.form.input name='icon' placeholder='Icon Menu' />
                    <small>
                        <a href="https://icons.getbootstrap.com/" target="_blank">Lihat referensi icon</a>
                    </small>

                    {{-- Input Url --}}
                    @php
                        $host = env('APP_URL') . '/'; // Nyandak alamat aplikasi
                    @endphp
                    <x-admin.components.form.input-group name='url' :textGroup="$host" disabled='disabled' />
                    <small class="badge border-light border-1 text-black-50">Gambaran url aplikasi</small>

                    {{-- Input Posisi Menu --}}
                    <x-admin.components.form.select name='position' required='required' placeholder='Posisi Menu'>
                        <option value="tautan">Tautan Navigasi</option>
                        <option value='navbar'>Navbar</option>
                        <option value="sidebar">Sidebar</option>
                    </x-admin.components.form.select>

                    {{-- Input Description --}}
                    <x-admin.components.form.textarea name='description' placeholder='Deskripsi Menu' tinggi='100' />

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click='resetForm' class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Batalkan
                </button>

                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Simpan Data
                </button>

            </div>
        </form>

    </x-admin.components.modal.modal>

    <!-- Modal Create Menu-->
    <x-admin.components.modal.modal id='formCreateMenu'>

        {{-- Header Modal --}}
        <x-admin.components.modal.header id={{ $id }} title="Formulir tambah data baru" />

        <form wire:submit='createData' method="POST">

            <div class="modal-body">
                <div class="row g-4">
                    <input type="hidden" class="form-control" wire:model.live='id' required='required' />

                    {{-- Baris kanggo input menu sareng icon --}}
                    {{-- Input Menu Name --}}
                    <x-admin.components.form.input name='menu' placeholder='Nama Menu' />

                    {{-- Input Icon Menu --}}
                    <x-admin.components.form.input name='icon' placeholder='Icon Menu' />
                    <small>
                        <a href="https://icons.getbootstrap.com/" target="_blank">Lihat referensi icon</a>
                    </small>

                    {{-- Baris kanggo input url sareng posisi --}}
                    {{-- Input Url --}}
                    @php
                        $host = env('APP_URL') . '/'; // Nyandak alamat aplikasi
                    @endphp
                    <x-admin.components.form.input-group name='url' :textGroup="$host" disabled='disabled' />
                    <small class="badge border-light border-1 text-black-50">Gambaran url aplikasi</small>

                    {{-- Input Posisi Menu --}}
                    <x-admin.components.form.select name='position' required='required' placeholder='Posisi Menu'>
                        <option value="tautan">Tautan Navigasi</option>
                        <option value='navbar'>Navbar</option>
                        <option value="sidebar">Sidebar</option>
                    </x-admin.components.form.select>

                    {{-- Input Description --}}
                    <x-admin.components.form.textarea name='description' placeholder='Deskripsi Menu'
                        tinggi='100' />

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click='resetForm' class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    Batalkan
                </button>

                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Simpan Data
                </button>

            </div>
        </form>

    </x-admin.components.modal.modal>
</div>
