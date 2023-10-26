<div class="row g-4">
    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    {{-- Data Table Pivot Menu --}}
    @livewire('admin.assign.table', [], key('table'))

    {{-- Form Create Assign --}}
    @livewire('admin.assign.create', [], key('create'))

    {{-- Form Update Assign --}}
    @livewire('admin.assign.update', [], key('update'))

</div>
