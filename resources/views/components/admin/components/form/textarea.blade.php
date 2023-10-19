<div class="col-{{ $size ?? 12 }}">
    <div class="form-floating">
        <textarea class="form-control" placeholder="{{ $placeholder ?? 'Not Set' }}" wire:model.live='{{ $name }}'
            style="height: 150px;" {{ $disabled ?? null }} {{ $required ?? null }}></textarea>
        <label>{{ $placeholder ?? 'Not Set' }}</label>

        @error($name)
            <div class="alert alert-warning"> {{ $message }} </div>
        @enderror
    </div>
</div>
