{{-- In work, do what you enjoy. --}}

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

    {{-- Tabs Content Similaritas --}}
    <div class="row g-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <x-admin.components.card.card size=12 title='Data Pengajuan' titleSpan='Pengumpulan Skripsi'>

                <x-admin.components.tabs.nav id="tab-similaritas">
                    <x-admin.components.tabs.nav-link id="tab-1" active="active" text="Buat Pengajuan" />
                    <x-admin.components.tabs.nav-link id="tab-2" text="Resume Pengajuan" />
                </x-admin.components.tabs.nav>

                <x-admin.components.tabs.tab-content id="myTabjustified">
                    <x-admin.components.tabs.content active="active" id="tab-1">
                        @livewire('Praja.PengumpulanSkripsi.Pengajuan', [], key('form'))
                    </x-admin.components.tabs.content>

                    <x-admin.components.tabs.content id="tab-2">
                        @livewire('Praja.PengumpulanSkripsi.Resume', [], key('table'))

                    </x-admin.components.tabs.content>
                </x-admin.components.tabs.tab-content>
            </x-admin.components.card.card>
        </div>
    </div>

    @livewire('praja.PengumpulanSkripsi.form-pengajuan')
</div>
