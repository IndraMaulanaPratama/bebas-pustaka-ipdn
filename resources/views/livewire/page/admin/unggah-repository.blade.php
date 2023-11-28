{{-- If your happiness depends on money, you will never be happy with yourself. --}}

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
    @livewire('Admin.Repository.Table', [], key('table'))

    {{-- Form Reject Data --}}
    @livewire('Admin.Repository.Reject', [], key('reject'))

</div>
