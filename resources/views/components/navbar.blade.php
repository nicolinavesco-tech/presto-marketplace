<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid d-flex flex-column p-0">
        <div class="d-none d-lg-flex justify-content-center w-100 border-bottom border-1 firstLine">
            <x-_locale lang="it"/>
            <x-_locale lang="en"/>
            <x-_locale lang="ru"/>
            <div class="d-flex gap-4 mx-auto">
                <span class="topbar-link">Magazine</span>
                <span class="topbar-link">Consigli per la vendita</span>
                <span class="topbar-link">Negozi e Aziende</span>
                <span class="topbar-link">Subito per le Aziende</span>
                <span class="topbar-link">Assistenza</span>
                <span class="topbar-link">Ricerche salvate</span>
                <span class="topbar-link">Preferiti</span>
            </div>
                @auth
                <div class="d-flex me-4 gap-3 ">
                    <!-- inizio collegamento area revisore -->
                    @if(Auth::user()->is_revisor)
                    <div class="nav-item list-unstyled">
                        <a href="{{route("revisor.index")}}" class="nav-link btn btn-outline-danger  py-0 px-2 btn-sm position-relative w-sm-25"><i class="fa-brands fa-black-tie" style="color: #ff0000;"></i> Revisor
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{\App\Models\Article::toBeRevisedCount()}}
                            </span>
                        </a>
                    </div>
                    @endif
                    <!-- fine collegamento area revisore -->
                    {{-- inizio amministratore --}}
                    @if(Auth::user()->is_admin)
                    <div class="nav-item list-unstyled">
                        <a href="{{route("admin.index")}}" class="nav-link btn btn-outline-success  py-0 px-2 btn-sm position-relative w-sm-25"><i class="fa-solid fa-user-tie" style="color: #006b25;"></i> Admin</a>
                    </div>
                    @endif
                </div>
                @endauth
            </div>
            <div class="d-flex w-100 border-bottom border-1 secondLine ">
                <div class="box-nav">
                    <a href="{{route('home')}}" class="logo text-decoration-none text-danger ms-4"><img src="{{ asset('media/logo.png') }}" alt="" class="logoPresto"></a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse w-100 d-flex justify-content-end me-4 navbar-custom navbarDrop" id="navbarNavDropdown">
                    <ul class="navbar-nav  d-lg-flex flex-row gap-4">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                        </li>
                        @auth
                        <li class="nav-item helloPhrase">
                            <a class="nav-link active fw-bold" href="">Benvenut* {{Auth::user()->name}}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('article_create')}}" class="inputCreate fw-bold text-decoration-none">
                                <i class="fa-solid fa-plus plus-btn" style="color: #ff0000;"></i> Inserisci annuncio
                            </a>
                        </li>
                        <li>
                            <a class="nav-link all-articles" aria-current="page" href="{{route('article_index')}}">Tutti articoli</a>
                        </li>
                        <form action="{{route('logout')}}" method="POST" class="text-center">
                            @csrf
                            <button class="btn" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                        </form>
                        @else
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="{{route('login')}}">Accedi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">Registrati</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Lavora con noi</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>


</nav>