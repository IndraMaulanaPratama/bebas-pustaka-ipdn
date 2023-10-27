<div class="col-12">
    <x-admin.components.card.card size=12 title='Data Role' titleSpan='Status Aktif'>
        <div class="row g-4">
            <div class="col-12">

                {{-- Baris bagian search sareng tombol tambih data --}}
                <div class="row justify-content-between">

                    {{-- Tombol Tambah Data --}}
                    <div class="col-4">
                        {{-- Input Search --}}
                        <button class="btn btn-outline-primary" {{ $buttonCreate }} type="button" data-bs-toggle="modal"
                            data-bs-target="#formCreateRole">
                            <span class="bi bi-plus-circle" role="status" aria-hidden="true"></span>
                            Tambah Data
                        </button>
                    </div>

                    {{-- Input Pencarian Data --}}
                    <div class="col-4">
                        <x-admin.components.form.input size=12 type='text' name='search' placeholder='Cari Data' />
                    </div>
                </div>


                {{-- Table data Role --}}
                <table class="table table-responsive table-hover">

                    <thead>
                        <tr>
                            <th scope="col" width=3%>#</th>
                            <th scope="col">Role</th>
                            <th scope="col" colspan="2" width=5%>Option</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($role as $item)
                            <tr wire:key='{{ $item->ROLE_ID }}'>
                                <th scope="row"> {{ $loop->index + $role->firstItem() }} </th>
                                <td>{{ $item->ROLE_NAME }}</td>
                                {{-- Option Row --}}
                                <td>
                                    <button type="button" {{ $buttonUpdate }}
                                        class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateRole"
                                        wire:click="updateRole('{{ $item->ROLE_ID }}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" {{ $buttonDelete }}
                                        class="btn rounded-pill btn-sm btn-outline-danger"
                                        wire:click="deleteRole('{{ $item->ROLE_ID }}')"
                                        wire:confirm='Anda yakin akan menghapus Role {{ $item->ROLE_NAME }} ini?'>
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </td> <!-- END Of OPTION ROW !-->

                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <x-admin.tamplates.paginate.paginate :item="$role" />

            </div>
        </div>
    </x-admin.components.card.card>

    <!-- Modal Update Role-->
    <x-admin.components.modal.modal id='formUpdateRole'>

        {{-- Header Modal --}}
        <x-admin.components.modal.header id={{ $id }} title="Formulir Ubah Data Role" />

        <form wire:submit='updateData' method="POST">
            <div class="modal-body">
                <input type="hidden" wire:model.live='id' />

                {{-- Input Nama Role --}}
                <x-admin.components.form.input name='name' placeholder='Nama Role' />
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

    <!-- Modal Create Role-->
    <x-admin.components.modal.modal id='formCreateRole'>

        {{-- Header Modal --}}
        <x-admin.components.modal.header id={{ $id }} title="Formulir buat data baru" />

        <form wire:submit='createData' method="POST">
            <div class="modal-body">
                {{-- Input Nama Role --}}
                <x-admin.components.form.input name='name' placeholder='Nama Role' />
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
</div>
