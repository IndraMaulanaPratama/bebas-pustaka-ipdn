{{-- Care about people's approval and you will be their prisoner. --}}

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
    @livewire('Admin.SkripsiPerpustakaan.Table', [], key('table'))

    {{-- Form Reject Data --}}
    @livewire('Admin.SkripsiPerpustakaan.Reject', [], key('reject'))

</div>
