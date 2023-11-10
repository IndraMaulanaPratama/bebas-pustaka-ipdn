<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        Showing {{ $item->firstItem() }} to {{ $item->lastItem() }} out of {{ $item->total() }} items
    </div>
    <div class="col-8 d-flex align-items-end flex-column">
        {{ $item->links() }}
    </div>
</div>
