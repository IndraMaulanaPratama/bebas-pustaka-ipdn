<div class="col-{{ $size ?? 12 }}">
    <div class="form-floating mb-3">
        <select class="form-select" wire:model.live='{{ $name }}' id="{{ $name }}" aria-label="State"
            {{ $required ?? null }} {{ $disabled ?? null }}>
            <option selected"></option>
            {{ $slot }}
        </select>
        <label for="{{ $name }}">{{ $placeholder ?? 'Select Form' }}</label>
    </div>
    @error($name)
        <div class="alert alert-warning"> {{ $message }} </div>
    @enderror
</div>
