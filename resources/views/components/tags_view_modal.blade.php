
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="tags_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Available tags</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">

                            <p> Use the tags below as placeholders for a more personalized message.</p>
                            <ul class="list-group list-group-flush">
                                @foreach (Batch::$tags as $tag => $desc)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <code>{{ $tag }}</code>
                                        <span class="text-muted">{{ $desc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
