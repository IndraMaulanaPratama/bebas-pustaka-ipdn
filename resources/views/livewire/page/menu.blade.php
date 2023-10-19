<div class='row'>
    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    <livewire:admin.menu.create :title="$title" :spanTitle="$spanTitle" :actionName='$actionName' />

    <livewire:admin.menu.table />

</div>
