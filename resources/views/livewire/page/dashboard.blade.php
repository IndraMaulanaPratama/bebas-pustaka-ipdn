<div class="">

    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    <?php if ('admin' == $role) { ?>
        @livewire('Admin.Dashboard.Dashboard', [], key('dashboard-admin'))
    <?php } elseif ('praja' == $role) { ?>
        @livewire('Praja.Dashboard.Dashboard', [], key('dashboard-praja'))
    <?php } ?>

</div>
