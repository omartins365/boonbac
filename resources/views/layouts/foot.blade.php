<footer class="container w-100 bg-opacity-25 bg-light mt-5 p-2 pt-5">
    <div class="position-relative">
        <div class="position-absolute bottom-0 start-50 translate-middle-x">
            <div class="vstack gap-1 text-center mt-5">

                <ul class="list-inline text-muted d-flex justify-content-center gap-3">
                    <!-- <li>follow us on </li> -->
                    {{-- @if (isset($owner)) --}}

                    {{-- @endif --}}
                    @if (Setting::for('facebook'))
                        <li class="list-inline-item">
                            <a class="text-decoration-none text-dark"
                                href="https://facebook.com/{{ Setting::for('facebook') }}"> <i
                                    class="fab fa-facebook fa-3x"></i></a>
                        </li>
                    @endif
                    <li class="list-inline-item">
                        <a href="#was_canvas" class="text-dark" data-bs-toggle="offcanvas" data-bs-target="#was_canvas"
                            aria-controls="was_canvas">
                            <i class="fab fa-whatsapp fa-3x"></i></a>
                    </li>
                    @if (Setting::for('twitter'))
                        <li class="list-inline-item">
                            <a class="text-decoration-none text-dark"
                                href="https://twitter.com/{{ Str::of(Setting::for('twitter'))->replace('@', '') }}"><i
                                    class="fab fa-twitter fa-3x"></i></a>
                        </li>
                    @endif
                    @if (Setting::for('support-mail'))
                        <li class="list-inline-item">
                            <a class="text-decoration-none text-dark"
                                href="mailto:{{ Str::of(Setting::for('support-mail')) }}"><i
                                    class="fas fa-envelope fa-3x"></i></a>
                        </li>
                    @endif
                    <!-- <li><a href="#" class="fab fa-dribbble"></a></li> -->
                    <!-- <li><a href="#" class="fab fa-behance"></a></li> -->
                </ul>
                @if (Setting::for('address'))
                    <span><i class="fas fa-location-pin"></i> {{ Setting::for('address') }}</span>
                @endif
                {{-- <div class="0"> --}}
                <ul class="list-inline m-0 p-0">
                    <li class="list-inline-item"><a class="text-decoration-none text-dark"
                            href="{{ url('/') }}#about-us">About
                            Us</a></li>
                    <li class="list-inline-item"><a class="text-decoration-none text-dark"
                            href="{{ url('/') }}/privacy">Privacy
                            Policy</a></li>
                    <li class="list-inline-item"><a class="text-decoration-none text-dark"
                            href="{{ url('/') }}/terms-of-use">Terms of Use</a></li>
                                                <li class="list-inline-item"><a class="text-decoration-none text-dark"
                            href="https://blog.colinkwa.com.ng">Blog</a></li>
                </ul>
                {{-- </div> --}}
                <span class="text-muted">
                    Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</span>

            </div>
        </div>
    </div>
</footer>
