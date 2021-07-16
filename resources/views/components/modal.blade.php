<div class="modal fade" id="{{ $name }}" ref="{{ $name }}" tabindex="-1" {{ $attributes }}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click.stop="{{ $successEvent }}">Save</button>
            </div>
        </div>
    </div>
</div>
