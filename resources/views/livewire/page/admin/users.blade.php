<div class="row">
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
        @livewire('admin.users.create', ['title' => $title, 'titleSpan' => $titleSpan, 'actionName' => $actionName])
    </div>

    <div class="row">
        @livewire('admin.users.table')
    </div>

    @livewire('admin.users.update')

</div>
