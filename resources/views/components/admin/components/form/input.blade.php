<div class="col-{{ $size ?? 12 }}">
    <div class="form-floating">
        <input type="{{ $type ?? 'text' }}" wire:model.live='{{ $name }}'
            placeholder="{{ $placeholder ?? 'Not set' }}" class="form-control" maxlength="{{ $maxlength ?? 150 }}"
            {{ $required ?? null }} {{$disabled ?? null}}>

        <label>{{ $placeholder ?? 'Not set' }}</label>

        @error($name)
            <div class="alert alert-warning"> {{ $message }} </div>
        @enderror
    </div>
</div>
