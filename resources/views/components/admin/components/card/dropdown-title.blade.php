<div class="filter">
    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
            <h6> {{ $title ?? 'Option' }} </h6>
        </li>

        {{ $slot }}

    </ul>
</div>
