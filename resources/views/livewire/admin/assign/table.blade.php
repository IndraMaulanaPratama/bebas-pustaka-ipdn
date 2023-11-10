<div>
    <x-admin.components.card.card size=12 title="Data Assign Role" titleSpan='Aktif'>

        {{-- Baris bagian search sareng tombol tambih data --}}
        <div class="row g-2 justify-content-between">

            {{-- Tombol Tambah Data --}}
            <div class="col-lg-4 col-md-6 col-sm-12">
                {{-- Input Search --}}
                <button class="btn {{ $buttonCreate }} btn-outline-primary" type="button" data-bs-toggle="modal"
                    data-bs-target="#formCreateAssign" wire:click='resetForm'>
                    <span class="bi bi-plus-circle" role="status" aria-hidden="true"></span>
                    Tambah Data
                </button>
            </div>

            {{-- Input Pencarian Data --}}
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-admin.components.form.input size=12 type='text' name='search' placeholder='Cari Data' />
            </div>
        </div>


        {{-- Data Table Access --}}
        <div class="table-responsive">
            <table class="table table-hover">

                <thead>
                    <tr>
                        <th scope="col" width=3%>#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col" colspan="3" width=5%>Option</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($assign as $item)
                        <tr>
                            <th scope="row"> {{ $loop->index + $assign->firstItem() }} </th>
                            <td> {{ $item->role->ROLE_NAME ?? null }} </td>
                            <td> {{ $item->menu[0]->MENU_NAME ?? null }} </td>
                            <td> {{ $item->PIVOT_DESCRIPTION }} </td>

                            {{-- Option Row --}}
                            {{-- Button Edit --}}
                            <td>
                                <button type="button" {{ $buttonUpdate }}
                                    class="btn btn-sm btn-outline-success rounded-pill"
                                    wire:click="updatePivot('{{ $item->PIVOT_ID }}')" data-bs-toggle="modal"
                                    data-bs-target="#formUpdateAssign">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>

                            {{-- Button Delete --}}
                            <td>
                                <button type="button" {{ $buttonDelete }}
                                    class="btn rounded-pill btn-sm btn-outline-danger"
                                    wire:click='deletePivot("{{ $item->PIVOT_ID }}")'
                                    wire:confirm='Anda yakin akan menghapus menu {{ $item->menu[0]->MENU_NAME ?? null }} ini?'>
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td> <!-- END Of OPTION ROW !-->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-admin.tamplates.paginate.paginate :item="$assign" />

    </x-admin.components.card.card>
</div>
