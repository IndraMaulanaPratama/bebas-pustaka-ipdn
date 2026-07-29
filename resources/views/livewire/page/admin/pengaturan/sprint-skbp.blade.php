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
    {{-- Formulir --}}
    @livewire('Admin.Pengaturan.SprintSkbp.Form', [], key('form'))

    {{-- Embed PDF --}}
    @livewire('Admin.Pengaturan.SprintSkbp.PreviewSurat', [], key('surat'))

</div>
