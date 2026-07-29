{{-- Be like water. --}}

<div class="row">
    <div wire:key="alerts">
    @if (session('success'))
        <x-admin.components.alert.success text="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-admin.components.alert.warning text="{{ session('warning') }}" />
    @endif

    @if (session('error'))
        <x-admin.components.alert.error text="{{ session('error') }}" />
    @endif

    </div>
    {{-- Data --}}
    @livewire('Admin.BebasPustaka.Table', [], key('table'))

</div>
