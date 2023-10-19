<div class="col-{{ $size ?? 12 }}">
    <div class="input-group has-validation">
        <span class="input-group-text"> {{ $textGroup ?? null }} </span>
        <input type="text" name="text" wire:model.live='{{ $name }}' class="form-control"
            id="{{ $name }}" maxlength="{{ $maxlength ?? 150 }}" {{ $required ?? null }} {{$disabled ?? null}}>
    </div>

    @error($name)
        <div class="alert alert-warning"> {{ $message }} </div>
    @enderror
</div>
