<div class="col-12">

    {{-- Card Form Create User --}}
    <x-admin.components.card.card size=12 title='List Penggguna' titleSpan='Status Aktif'>

        {{-- Baris bagian search sareng tombol tambih data --}}
        <div class="row g-2 justify-content-between">

            {{-- Tombol Tambah Data --}}
            <div class="col-lg-4 col-md-6 col-sm-12">
                {{-- Input Search --}}
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal"
                    data-bs-target="#formCreateData">
                    <span class="bi bi-plus-circle" role="status" aria-hidden="true"></span>
                    Tambah Data
                </button>
            </div>

            {{-- Input Pencarian Data --}}
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-admin.components.form.input size=12 type='text' name='search' placeholder='Cari Data' />
            </div>
        </div>



        {{-- Data Table User --}}
        <div class="table-responsive">
            <table class="table table-hover">

                <thead>
                    <tr>
                        <th scope="col" width=3%>#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Photo</th>
                        <th scope="col" colspan="2" width=5%>Option</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                        <tr wire:key='$item->id'>
                            <th scope="row"> {{ $loop->index + $data->firstItem() }} </th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role->ROLE_NAME ?? '' }}</td>
                            <td>
                                <img src="{{ asset('foto_pegawai/' . $item->photo) }}" width="40px"
                                    class="rounded-circle" alt="{{ $item->name }}">
                            </td>

                            {{-- Button Update User --}}
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill"
                                    wire:click="resetPassword('{{ $item->id }}')" data-bs-toggle="modal"
                                    data-bs-target="#modalResetPassword">
                                    <i class="bi bi-key-fill"></i>
                                </button>
                            </td>


                            {{-- Button Update User --}}
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-success rounded-pill"
                                    wire:click="updateUser('{{ $item->id }}')" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>

                            {{-- Button Delete User --}}
                            <td>
                                <button type="button" {{ $buttonDelete }}
                                    class="btn rounded-pill btn-sm btn-outline-danger"
                                    wire:click='deleteUser("{{ $item->id }}")'
                                    wire:confirm='Anda yakin akan menghapus pengguna {{ $item->name }} ini?'>
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td> <!-- END Of OPTION ROW !-->
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- Paginate Table --}}
        <x-admin.tamplates.paginate.paginate :item="$data" />

    </x-admin.components.card.card>

</div>
