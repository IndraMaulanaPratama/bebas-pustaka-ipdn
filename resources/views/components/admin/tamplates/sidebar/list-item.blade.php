<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#{{ $name }}-nav" data-bs-toggle="collapse" href="#">
        <i class="bi {{ $icon ?? 'bi-gear-wide-connected' }}"></i><span>{{ $text }}</span><i
            class="bi bi-chevron-down ms-auto"></i>
    </a>

    <ul id="{{ $name }}-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        {{ $slot }}
    </ul>
</li>
