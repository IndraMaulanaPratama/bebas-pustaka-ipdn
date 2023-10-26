<div class="row mb-{{ $mb ?? 2 }} align-items-center">
    <label class="col-{{ $col ?? 8 }} col-form-label"> {{ $label ?? 'This is Label' }} </label>
    <div class="col-auto">
        <div class=" form-switch">
            <input wire:model.live="{{ $name }}" value="{{$value ?? false}}" class="form-control form-check-input" type="checkbox"
                id="{{ $name }}" {{ $required ?? null }} {{ $disabled ?? null }}>
        </div>
    </div>
</div>
