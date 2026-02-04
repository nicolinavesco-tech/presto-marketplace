<nav class="navbar navbar-expand-lg navbar-light">
    <!-- <span class="miniIcon"></span>
        <span class="miniIcon"></span>
        <span class="miniIcon"></span>
        <span class="miniIcon"></span>
        <span class="miniIcon"></span>
        <span class="miniIcon"></span>
        <span class="miniIcon"></span> -->
        <div class="container">
            
            <a href="" class="logo text-decoration-none text-danger">Presto.it</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto gap-4 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{route("login")}}">Accedi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("register")}}">Registrati</a>
                    </li>
                    @auth
                    
                    <li class="nav-item">
                        <button class=" btn-navbar fw-bold">
                            <i class="fa-solid fa-plus" style="color: #ff0000;"></i> Inserisci annuncio
                        </button>
                    </li>
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            
        </div>
    </nav>