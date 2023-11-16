<div class="row">
    {{-- Be like water. --}}
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
    @livewire('Admin.DonasiPustaka.Table', [], key('table'))

    {{-- Form Reject --}}
    @livewire('Admin.DonasiPustaka.Reject', [], key('formReject'))

</div>
