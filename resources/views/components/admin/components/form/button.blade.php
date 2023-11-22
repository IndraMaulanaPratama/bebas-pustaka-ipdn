<button type="{{ $type ?? 'button' }}" class="btn btn-outline-{{ $color ?? 'secondary' }} {{ $invisible ?? null}} btn-{{$size ?? 'md'}} ">
    <small>{{ $text ?? 'button' }}</small>
</button>
