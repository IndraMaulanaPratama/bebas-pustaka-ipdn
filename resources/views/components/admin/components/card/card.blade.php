<div class="col-{{ $size ?? 4 }}">
    <div class="card info-card {{ $type ?? 'sales' }}-card"> <!-- sales (biru), revenue (hijau), customers (orange) -->
        <div class="card-body">

            <div class="card-title mb-3">{{ $title ?? null }} <span>{{ $titleSpan ?? null }}</span> </div>

            {{ $slot }}

        </div>
    </div>
</div>
