<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(Route::has("login"))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route("home") }}">Home</a>
                        </li>

                        @if(Route::has("logout"))
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route("logout") }}"
                                   onclick="document.getElementById('form-logout').submit();">Logout</a>
                            </li>
                            <form id="form-logout" action="{{ route("logout") }}" method="post">
                                @csrf
                            </form>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route("login") }}">Login</a>
                        </li>

                        @if(Route::has("register"))
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route("register") }}">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
