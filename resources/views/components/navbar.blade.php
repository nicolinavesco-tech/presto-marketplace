<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid d-flex flex-column p-0">
        <div class="d-flex gap-4 justify-content-center w-100 border-bottom border-1 firstLine">
            <span class="topbar-link">Magazine</span>
            <span class="topbar-link">Consigli per la vendita</span>
            <span class="topbar-link">Negozi e Aziende</span>
            <span class="topbar-link">Subito per le Aziende</span>
            <span class="topbar-link">Assistenza</span>
            <span class="topbar-link">Ricerche salvate</span>
            <span class="topbar-link">Preferiti</span>
        </div>
        <div class="d-flex w-100 border-bottom border-1 secondLine">
            <div class="w-100">
                <a href="" class="logo text-decoration-none text-danger">Presto.it</a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse w-100" id="navbarNavDropdown">
                <ul class="navbar-nav  gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                    </li>
                    @auth
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
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorie</a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                            <li>
                                <a href="" class="dropdown-item text-capitalize">{{$category->name}}</a>
                            </li>
                            @if (!$loop->last)
                            <hr class="dropdown-divider">
                            @endif
                            @endforeach
                        </ul>
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
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorie</a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                            <li>
                                <a href="{{route("byCategory", ["category" => $category])}}" class="dropdown-item text-capitalize">{{$category->name}}</a>
                            </li>
                            @if (!$loop->last)
                            <hr class="dropdown-divider">
                            @endif
                            @endforeach
                        </ul>
                    </li>

                    @endauth
                </ul>
            </div>
        </div>


</nav>