@php
    use App\Models\pivotMenu;

    $role = Auth::user()->role;
    $pivot = pivotMenu::with(['menu'])
        ->where('PIVOT_ROLE', $role->ROLE_ID)
        ->get();

@endphp

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <x-admin.tamplates.sidebar.link text="Beranda" navigate="/" icon="grid" />

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

            @if ($role->ROLE_NAME == 'Super Admin')
                <x-admin.tamplates.sidebar.link text="Manajemen Pengguna" navigate="user-manajemen"
                    icon="bi-person-lines-fill" />

                <x-admin.tamplates.sidebar.link text="Manajemen Menu" navigate="menu" icon="bi-menu-button-fill" />
            @endif <!-- Tungtung tina menu super admin -->

            {{-- <x-admin.tamplates.sidebar.link text="Manajemen Akses" navigate="akses" icon="bi-universal-access-circle" /> --}}

        @endif <!-- Tungtung tina menu admin -->


        {{-- Contoh Dropdown menu --}}
        <x-admin.tamplates.sidebar.list-item text="Petunjuk" name="pustaka">
            <x-admin.tamplates.sidebar.item-link text="Alert-" navigate="/" icon="circle" />
        </x-admin.tamplates.sidebar.list-item>


    </ul>

</aside>
