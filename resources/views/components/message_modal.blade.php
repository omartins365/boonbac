<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doMessage{{ $message->id ?? 0 }}">
    @isset($message)
        Edit
    @else
        <i class="fas fa-bars-staggered"></i> Create Message
    @endisset
</button>

<!-- Modal -->
<div class="modal fade" id="doMessage{{ $message->id ?? 0 }}" tabindex="-1" aria-labelledby="doMessage{{ $message->id ?? 0 }}Label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doMessage{{ $message->id ?? 0 }}Label">
                    @isset($message)
                        <i class="fas fa-pen"></i> Edit {{ $message->name }}
                    @else
                        <i class="fas fa-add"></i> Add New Message
                    @endisset
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="doMessage{{ $message->id ?? 0 }}Form"
                      action="{{ isset($message) && $message->exists ? route('main.dash.messages.update', ['message' => $message->id]) : route('main.dash.messages.store') }}"
                      method="post">
                    @csrf
                    @method(isset($message) && $message->exists ? 'PUT' : 'POST')
                    <div class="mb-3">
                        <label for="doMessage{{ $message->id ?? 0 }}subject" class="form-label">Message Title</label>
                        <input type="text" class="form-control" id="doMessage{{ $message->id ?? 0 }}subject"
                               name="message[{{ $message->id ?? 0 }}][subject]" required
                               value="{{ old("message")[$message->id ?? 0]['subject']??$message->subject ?? '' }}" placeholder="Message Title">
                    </div>
                    <div class="mb-3">
                        <label for="doMessage{{ $message->id ?? 0 }}message" class="form-label">Content</label>
                        <input type="text" class="form-control" id="doMessage{{ $message->id ?? 0 }}message"
                               name="message[{{ $message->id ?? 0 }}][message]" required
                               value="{{ old("message")[$message->id ?? 0]['message']??$message->message ?? '' }}" placeholder="Content of the message">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="doMessage{{ $message->id ?? 0 }}Form" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
