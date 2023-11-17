{{-- The best athlete wants his opponent at his best. --}}
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

    {{-- Data Table --}}
    @livewire('Admin.DonasiFakultas.Table', [], key('table'))

    {{-- Form Reject --}}
    @livewire('Admin.DonasiFakultas.Reject', [], key('formReject'))

</div>
