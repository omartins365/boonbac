@php
    $last_msg = \App\Models\Notification::broadcast()->latest()->first();
@endphp
@isset($last_msg)
    <div {{ $attributes->class(['modal']) }} tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i
                                class="bi bi-chat-left-text"></i> {{$last_msg->subject??'Important Announcement'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{$last_msg->message}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{route('customer.dashboard.notifications.show', ['notification' => $last_msg->id])}}"
                       class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            var timeInterval = 4 * 60 * 60 * 1000; // 4 hours in milliseconds

            // Check if the 'lastVisit' cookie exists
            var lastVisit = getCookie('read_msg-{{$last_msg->updated_at}}');
            if (lastVisit === '') {
                // If the cookie doesn't exist, show the modal and set the 'read_msg-{{$last_msg->updated_at}}' cookie
                myModal.show();
                setCookie('read_msg-{{$last_msg->updated_at}}', new Date().getTime(), 4);
            } else {
                // If the cookie exists, calculate the time difference
                var timeDifference = new Date().getTime() - parseInt(lastVisit);
                if (timeDifference >= timeInterval) {
                    // If the time difference is greater than or equal to the interval, show the modal
                    myModal.show();
                    setCookie('read_msg-{{$last_msg->updated_at}}', new Date().getTime(), 4);
                }
            }

            function setCookie(name, value, hours) {
                var expires = '';
                if (hours) {
                    var date = new Date();
                    date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
                    expires = '; expires=' + date.toUTCString();
                }
                document.cookie = name + '=' + value + expires + '; path=/';
            }

            function getCookie(name) {
                var nameEQ = name + '=';
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return '';
            }
        });
    </script>
@endisset
