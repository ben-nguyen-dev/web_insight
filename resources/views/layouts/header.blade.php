<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <h3>
                <img src="{{ asset('images/logo.png') }}" />
                <span class="toggle-logo">
                <span class="logo-color"></span>
                </span>
            </h3>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    {{-- <li class="nav-item nav-menu">
                        <a href="" class="nav-link">Vårt lag</a>
                    </li>
                    <li class="nav-item nav-menu">
                        <a href="" class="nav-link">Det här gör vi</a>
                    </li> --}}
                    <li class="nav-item nav-menu">
                        <a href="" class="nav-link">Inspiration</a>
                    </li>
                    <li class="nav-item nav-menu">
                        <a href="" class="nav-link">Möten</a>
                    </li>
                    @if (Auth::user()->isAdministrator(\App\Enum\RoleEnum::ROLE_COMPANY_ADMIN))
                        <li class="nav-item nav-menu">
                            <a href="{{ route('manager.users') }}" class="nav-link">Company Users</a>
                        </li>
                        <li class="nav-item nav-menu">
                            <a href="{{ route('manager.companies') }}" class="nav-link">Company Manager</a>
                        </li>
                    @endif
                    <li class="nav-item nav-menu dropdown">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <i class="fas fa-user"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
