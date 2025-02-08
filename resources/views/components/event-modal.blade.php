<div class="modal fade" id="imageModal{{ $id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel{{ $id }}">{{$title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ url('storage/'.$image) }}" class="img-fluid rounded" alt="Evento">
            </div>
        </div>
    </div>
</div>
