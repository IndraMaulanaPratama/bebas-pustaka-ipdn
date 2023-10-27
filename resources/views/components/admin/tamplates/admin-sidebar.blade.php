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

            {{-- User Menu --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Pengguna" navigate="user-manajemen"
                icon="bi-person-lines-fill" />

            {{-- Assign Menu --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Akses" navigate="assign-manajemen"
                icon="bi-universal-access-circle" />

            {{-- Manajemen Menu --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Menu" navigate="menu" icon="bi-menu-button-fill" />

            {{-- Role Menu --}}
            <x-admin.tamplates.sidebar.link text="Manajemen Role" navigate="role-manajemen" icon="bi-bar-chart-steps" />

            @if ($role->ROLE_NAME == 'Super Admin')
                {{-- Data Sampah --}}
                <x-admin.tamplates.sidebar.list-item text="Data Sampah" name="dropDown">
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

            {{-- <x-admin.tamplates.sidebar.link text="Manajemen Akses" navigate="akses" icon="bi-universal-access-circle" /> --}}

        @endif <!-- Tungtung tina menu admin -->


    </ul>

</aside>
