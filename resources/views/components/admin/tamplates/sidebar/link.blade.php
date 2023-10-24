{{-- Fungsi kanggo nangtoskeun menu nu nuju aktif --}}
@if (Route::currentRouteName() != $navigate)
    @php $active = 'collapsed'; @endphp
@endif


<li class="nav-item">
    <a class="nav-link {{ $active ?? null }}" href="{{ route($navigate) }}" wire:navigate>
        <i class="bi {{ $icon }}"></i>
        <span>{{ $text }}</span>
    </a>
</li><!-- End Dashboard Nav -->
