{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

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
    @livewire('Admin.SkripsiFakultas.Table', [], key('table'))

    {{-- Form Reject Data --}}
    @livewire('Admin.SkripsiFakultas.Reject', [], key('reject'))

</div>
