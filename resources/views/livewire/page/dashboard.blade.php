<div class="">

    <?php if ('admin' == $role) { ?>
        @livewire('Admin.Dashboard.Dashboard', [], key('dashboard-admin'))
    <?php } elseif ('praja' == $role) { ?>
        @livewire('Praja.Dashboard.Dashboard', [], key('dashboard-praja'))
    <?php } ?>

</div>
