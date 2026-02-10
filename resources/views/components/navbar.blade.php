<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid d-flex flex-column p-0">
        <div class="d-none d-lg-flex  gap-4 justify-content-center w-100 border-bottom border-1 firstLine">
            <span class="topbar-link">Magazine</span>
            <span class="topbar-link">Consigli per la vendita</span>
            <span class="topbar-link">Negozi e Aziende</span>
            <span class="topbar-link">Subito per le Aziende</span>
            <span class="topbar-link">Assistenza</span>
            <span class="topbar-link">Ricerche salvate</span>
            <span class="topbar-link">Preferiti</span>
        </div>
        <div class="d-flex w-100 border-bottom border-1 secondLine">
            <div class="box-nav">
                <a href="{{route('home')}}" class="logo text-decoration-none text-danger ms-4"><img src="{{ asset('media/logo.png') }}" alt="" class="logoPresto"></a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse w-100 d-flex justify-content-end me-4 navbarDrop" id="navbarNavDropdown">
                <ul class="navbar-nav d-lg-flex flex-row gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                    </li>
                    @auth
                    <!-- inizio collegamento area revisore -->
                    @if(Auth::user()->is_revisor)
                    <li class="nav-item">
                        <a href="{{route("revisor.index")}}" class="nav-link btn btn-outline-danger btn-sm position-relative w-sm-25">Zona revisore
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{\App\Models\Article::toBeRevisedCount()}}
                            </span>
                        </a>
                    </li>
                    @endif
                    <!-- fine collegamento area revisore -->
                    {{-- inizio amministratore --}}
                    @if(Auth::user()->is_admin)
                    <li class="nav-item">
                        <a href="{{route("admin.index")}}" class="nav-link btn btn-outline-success btn-sm position-relative w-sm-25">Zona amministratore</a>
                    </li>
                    @endif
                    {{-- fine amministratore --}}
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="">Benvenut* {{Auth::user()->name}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('article_create')}}" class="inputCreate fw-bold text-decoration-none">
                            <i class="fa-solid fa-plus" style="color: #ff0000;"></i> Inserisci annuncio
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" aria-current="page" href="{{route('article_index')}}">Tutti gli articoli</a>
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