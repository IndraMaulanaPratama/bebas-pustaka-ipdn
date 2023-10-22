<div class="col-{{ $size ?? 12 }}">
    <div class="form-floating">
        <textarea class="form-control" placeholder="{{ $placeholder ?? 'Input Form' }}" wire:model.live='{{ $name }}'
            style="height: 150px;" {{ $disabled ?? null }} {{ $required ?? null }}></textarea>
        <label>{{ $placeholder ?? 'Input Form' }}</label>

        @error($name)
            <div class="alert alert-warning"> {{ $message }} </div>
        @enderror
    </div>
</div>
