<li class="nav-item flex-fill" role="presentation">
    <button class="nav-link w-100 {{$active ?? null}}" data-bs-toggle="tab" data-bs-target="#{{ $id }}" type="button"
        role="tab" aria-controls="{{ $text ?? "text nav-link" }}" aria-selected="true">{{ $text ?? "text nav-link" }}</button>
</li>
