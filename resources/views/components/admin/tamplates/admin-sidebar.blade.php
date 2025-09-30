@php
    use App\Models\pivotMenu;
    use App\Models\bimbingan_pemustaka;

    $role = Auth::user()->role;
    $pivot = pivotMenu::with(['menu'])
        ->where('PIVOT_ROLE', $role->ROLE_ID)
        ->oldest()
        ->get();

    if ($role->ROLE_NAME == 'Praja Utama') {
        $npp = explode('@', Auth::user()->email)[0];

        // Cek Data Bimbingan Pemustaka
        $statusBimbingan = bimbingan_pemustaka::where('PEMUSTAKA_PRAJA', $npp)->first('PEMUSTAKA_STATUS');
        // dd($statusBimbingan['PEMUSTAKA_STATUS']);

        if ($statusBimbingan['PEMUSTAKA_STATUS'] == "Disetujui") {
            # code...
            $pivot = pivotMenu::with(['menu'])
                ->where('PIVOT_ROLE', $role->ROLE_ID)
                ->oldest()
                ->get();
        } else {
            $pivot = pivotMenu::with(['menu'])
                ->whereHas('menu', function ($query) {
                    $query->where('MENU_NAME', 'Bimbingan Pemustaka');
                })
                ->where('PIVOT_ROLE', $role->ROLE_ID)
                ->oldest()
                ->get();
        }
    }

@endphp

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <x-admin.tamplates.sidebar.link text="Beranda" navigate="dashboard" icon="grid" />

        <x-admin.tamplates.sidebar.heading text='Bebas Pustaka' />

        {{-- Logic kanggo nampilkeun data menu dumasar kana role nu login --}}
        @for ($i = 0; $i < count($pivot); $i++)
            @if ('sidebar' == $pivot[$i]->menu[0]->MENU_POSITION)
                <x-admin.tamplates.sidebar.link :text="$pivot[$i]->menu[0]->MENU_NAME" :navigate="$pivot[$i]->menu[0]->MENU_URL" :icon="$pivot[$i]->menu[0]->MENU_ICON" />
            @endif
        @endfor

        {{-- Menu kanggo area Admin --}}
        @if ($role->ROLE_NAME == 'Super Admin' || $role->ROLE_NAME == 'Admin Pustaka')
            <x-admin.tamplates.sidebar.heading text='Admin Area' />

            {{-- Role Manajemen --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Role" navigate="role-manajemen" icon="bi-bar-chart-steps" />

            {{-- Menu Manajemen --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Menu" navigate="menu" icon="bi-menu-button-fill" />

            {{-- User Manajemen --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Pengguna" navigate="user-manajemen"
                icon="bi-person-lines-fill" />

            {{-- Akses Manajemen --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Akses" navigate="assign-manajemen"
                icon="bi-universal-access-circle" />

            {{-- Pengaturan Website --}}
            <x-admin.tamplates.sidebar.list-item text="Pengaturan website" name="pengaturan" wire:key='pengaturan'>
                <x-admin.tamplates.sidebar.item-link text="Data Kepala Unit" navigate="/pengaturan/data-kepala-unit"
                    icon="circle" wire:key='1' />
                <x-admin.tamplates.sidebar.item-link text="File Sprint Bebas Pustaka" navigate="/pengaturan/sprint"
                    icon="circle" wire:key='2' />
                {{-- <x-admin.tamplates.sidebar.item-link text="Formulir Survei Praja"
                    navigate="/pengaturan/formulir/survei-praja" icon="circle" wire:key='3' />
                <x-admin.tamplates.sidebar.item-link text="Formulir Konten Literasi"
                    navigate="/pengaturan/formulir/konten-literasi" icon="circle" wire:key='4' />
                <x-admin.tamplates.sidebar.item-link text="Formulir Unggah Repository"
                    navigate="/pengaturan/formulir/unggah-repository" icon="circle" wire:key='5' /> --}}
            </x-admin.tamplates.sidebar.list-item>



            @if ($role->ROLE_NAME == 'Super Admin')
                {{-- Data Sampah --}}
                <x-admin.tamplates.sidebar.list-item text="Data Sampah" name="sampah" icon="bi-trash3-fill"
                    wire:key='sampah'>
                    <x-admin.tamplates.sidebar.item-link text="Data Pengguna" navigate="/" icon="circle"
                        wire:key='1' />
                    <x-admin.tamplates.sidebar.item-link text="Data Role" navigate="/" icon="circle"
                        wire:key='2' />
                    <x-admin.tamplates.sidebar.item-link text="Data Menu" navigate="/" icon="circle"
                        wire:key='3' />
                    <x-admin.tamplates.sidebar.item-link text="Data Asign" navigate="/" icon="circle"
                        wire:key='4' />
                    <x-admin.tamplates.sidebar.item-link text="Data Access" navigate="/" icon="circle"
                        wire:key='5' />
                </x-admin.tamplates.sidebar.list-item>
            @endif <!-- Tungtung tina menu super admin -->

        @endif <!-- Tungtung tina menu admin -->


    </ul>

</aside>
