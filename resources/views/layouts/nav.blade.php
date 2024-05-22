<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse navbarSupportedContent">
    <div id="header" class="position-sticky pt-5">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.home') }}" href="{{ route('main.dash.home') }}">
                    <i class="fas fa-house-user"></i>
                    Dashboard
                </a>
            </li>
        </ul>

        <ul class="nav flex-column mb-2">

            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.messages') }}" href="{{ route('main.dash.messages.index') }}"><i class="fas fa-envelope"></i>
                    {{ __('Announcement') }}</a>
            </li>
        </ul>
        {{--  <ul class="nav flex-column mb-2">

            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.bookings') }}" href="{{ route('main.dash.bookings.index') }}"><i class="fas fa-envelope"></i>
                    {{ __('Portfolio Requests') }}</a>
            </li>
        </ul>  --}}

        <h6 class="d-grid my-0">
            <span>
                <hr />
            </span>

        </h6>
        @can('manage-users')

            <ul class="nav flex-column">
                {{--  @can('manage-top-level')  --}}
                <li class="nav-item">
                    <a class="nav-link {{ Core::nav_route('main.dash.customers.*') }}"
                       href="{{ route('main.dash.customers.index') }}">
                        <i class="fas fa-user-group"></i>
                        Customers
                    </a>
                </li>

                <ul class="nav flex-column">
                    {{--  @can('manage-top-level')  --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Core::nav_route('main.dash.transactions.*') }}"
                           href="{{ route('main.dash.transactions.index') }}">
                            <i class="fas fa-business-time"></i>
                            Transactions
                        </a>
                    </li>
                    {{--  @endcan  --}}
                </ul>

                {{--  @endcan  --}}
            </ul>
        @endcan

        @can('update-setting')
            <h6 class="d-grid my-0">
            <span>
                <hr/>
            </span>

            </h6>
        <ul class="nav flex-column">
 <li class="nav-item">
                    <a class="nav-link {{ Core::nav_route('main.dash.stands.*') }}"
                       href="{{ route('main.dash.stands.index') }}">
                        <i class="fas fa-user-group"></i>
                        Charge Stands
                    </a>
                </li>
            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.plans.*') }}"
                   href="{{ route('main.dash.plans.index') }}">
                    <i class="fas fa-business-time"></i>
                    Plans
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.settings.index') }}" href="{{ route('main.dash.settings.index') }}">
                    <i class="fas fa-gears"></i>
                    Preferences
                </a>
            </li>

        </ul>
        @endcan
        @can('manage-staffs')
            <h6 class="d-grid my-0">
            <span>
                <hr />
            </span>

        </h6>
        <ul class="nav flex-column mb-2">

            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.dash.staffs') }}" href="{{ route('main.dash.staffs.index') }}"><i class="fas fa-users-gear"></i>
                    {{ __('Staffs') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route('main.register') }}" href="{{ route('main.register', ['staff']) }}"><i class="fas fa-user-plus"></i> {{ __('Create Staff') }}</a>
            </li>
        </ul>
        @endcan

        <h6 class="d-grid my-0">
            <span>
                <hr />
            </span>

        </h6>

        <ul class="nav flex-column mb-2">

            <li class="nav-item">
                <a class="nav-link {{ Core::nav_route(route('main.dash.staffs.profile')) }}" href="{{ route('main.dash.staffs.profile') }}"><i class="fas fa-user-pen"></i>
                    {{ __('Edit Profile') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('main.logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                    <i class="fas fa-door-open"></i>
                    {{ __('Logout') }}
                </a>
            </li>
        </ul>
    </div>
</nav>
