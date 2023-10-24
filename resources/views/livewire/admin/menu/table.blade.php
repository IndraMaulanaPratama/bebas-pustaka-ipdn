<div class="col-12">
    <x-admin.components.card.card size=12 title='List Menu' titleSpan='Status Aktif'>

        {{-- Input Search --}}
        <x-admin.components.form.input size=2 type='text' name='search' placeholder='Cari Data' />

        <table class="table table-hover">
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
                                wire:click="updateMenu('{{ $item->MENU_ID }}')">
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

        <x-admin.tamplates.paginate.paginate :item="$data" />

    </x-admin.components.card.card>
</div>
