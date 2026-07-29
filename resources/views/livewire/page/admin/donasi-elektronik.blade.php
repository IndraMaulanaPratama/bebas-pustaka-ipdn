{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
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
    @livewire('Admin.DonasiElektronik.Table', [], key('table'))

    {{-- Form Reject --}}
    @livewire('Admin.DonasiElektronik.Reject', [], key('formReject'))

</div>

