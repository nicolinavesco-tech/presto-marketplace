<x-layout>
    <main class="container login-wrapper position-relative" style="background-image: url('{{ asset('media/bg_login_2.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
        <div class="login-hero-text">
        <p class="hero-line-1">
            Vendi ciò che non usi più, e trova ciò che vuoi a dei prezzi super.
        </p>
        <p class="hero-line-2">
            Perché aspettare? Fai <strong>PRESTO</strong>
        </p>
    </div>
        <section class="row wh-75 justify-content-end align-items-end login-row">
            <article class="col-12 col-lg-4 login-article d-flex">
                <div class="login-card">
                    <h5 class="text-center"><strong>Accedi su Presto</strong></h5>
                    <p class="text-center">
                        Compra e vendi in una community con oltre 10 milioni di utenti.
                    </p>
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="mario@rossi.com" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password:</label>
                            <div>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-auto d-flex justify-content-center">
                            <a class="text-decoration-none text-dark" href="{{route('register')}}">
                                Non sei ancora registrato? <strong style="color:#f9423a">Registrati</strong>
                            </a>
                        </div>
                        <div class="col-auto box-buttons">
                            <button type="submit" class="mb-3 form-button w-50">Login</button>
                        </div>
                    </form>
                </div>
            </article>
        </section>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </main>
</x-layout>
