<div class="modal fade " id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}" aria-hidden="true"
    wire:ignore>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
