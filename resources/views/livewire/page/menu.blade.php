<div>
    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    <div class="row">
        <div class="col-8">
            <livewire:admin.menu.create :title="$title" :spanTitle="$spanTitle" :actionName='$actionName' />
        </div>

        <div class="col-4">
            <x-admin.components.card.card size=12>
                Asign Data Menu
            </x-admin.components.card.card>
        </div>
    </div>

    <div class="row">
        <livewire:admin.menu.table />
    </div>

</div>