<div class="row">
    {{-- In work, do what you enjoy. --}}
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
    @livewire('Admin.PinjamanFakultas.Table', [], key('table'))

    {{-- Form Reject --}}
    @livewire('admin.PinjamanFakultas.Reject', [], key('formReject'))

</div>
