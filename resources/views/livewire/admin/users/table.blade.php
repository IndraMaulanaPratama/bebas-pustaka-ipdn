<div class="col-12">

    {{-- Card Form Create User --}}
    <x-admin.components.card.card size=12 title='List Penggguna' titleSpan='Status Aktif'>

        {{-- Input Search --}}
        <x-admin.components.form.input size=2 type='text' name='search' placeholder='Cari Data' />

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
                            <img src="{{ asset('foto_pegawai/' . $item->photo) }}" width="40px" class="rounded-circle"
                                alt="{{ $item->name }}">
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
                            <button type="button" class="btn rounded-pill btn-sm btn-outline-danger"
                                wire:click='deleteUser("{{ $item->id }}")'
                                wire:confirm='Anda yakin akan menghapus pengguna {{ $item->name }} ini?'>
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </td> <!-- END Of OPTION ROW !-->
                    </tr>
                @endforeach
            </tbody>

        </table>

        <x-admin.tamplates.paginate.paginate :item="$data" />

    </x-admin.components.card.card>

</div>
