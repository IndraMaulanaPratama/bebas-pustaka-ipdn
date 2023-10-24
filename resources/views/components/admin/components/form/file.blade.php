<div class="col-{{ $size ?? 12 }}">
    <div class="form-floating">
        <input class="form-control" wire:model.live='{{ $name }}' placeholder="foto" type="file"
            {{ $required ?? null }} {{ $disable ?? null }}>
            <label>{{ $placeholder ?? 'Input Form' }}</label>

    </div>

    @error($name)
        <div class="alert alert-warning"> {{ $message }} </div>
    @enderror
</div>
