{{-- Nothing in the world is as soft and yielding as water. --}}

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
    @livewire('Admin.SkripsiSoftcopy.Table', [], key('table'))

    {{-- Form Reject Data --}}
    @livewire('Admin.SkripsiSoftcopy.Reject', [], key('reject'))

</div>
