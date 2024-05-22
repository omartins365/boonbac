<div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('favicon-32x32.png') }}" style="height: 30px; width:auto;"
            alt="{{ config('app.name', '') }}" />
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse navbarSupportedContent" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto fs-6">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('main.index') }}">
                    <i class="fas fa-home"></i>
                    <span
                        class="d-md-none d-lg-inline">{{ __('Home') }}</span></a>
            </li>

            <!-- Authentication Links -->
            @guest
                @if (Route::has('main.login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main.login') }}">
                            <i class="fas fa-sign-in"></i> <span class="d-md-none d-lg-inline"> {{ __('Login') }}
                            </span></a>
                    </li>
                @endif
            @else
                @if (!request()->routeIs('dash.*') && !request()->routeIs('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main.dash.home') }}">{{ __('Dashboard') }}</a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" style="z-index: 1050" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('main.dash.staffs.edit', ['user' => auth()->id()]) }}"><i
                                class="fas fa-user-pen"></i> {{ __('Edit Profile') }}</a>
                        <a class="dropdown-item" href="{{ route('main.logout') }}"
                            onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('main.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>
