{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

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

    {{-- Data --}}
    @livewire('Admin.BimbinganPemustaka.Table', [], key('table'))

    {{-- Form Reject Data --}}
    @livewire('Admin.BimbinganPemustaka.Reject', [], key('reject'))

</div>
