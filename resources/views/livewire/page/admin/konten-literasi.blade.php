{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
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
    {{-- Data Table --}}
    @livewire('Admin.KontenLiterasi.Table', [], key('table'))

    {{-- Form Reject --}}
    @livewire('Admin.KontenLiterasi.Reject', [], key('formReject'))

</div>
