<x-layout>
    <h1 class="text-center mt-5">Registrati</h1>
    <p class="text-center">
      Crea il tuo account per iniziare a vendere e comprare in tutta Italia.  
    </p>
    <main class="container">
        <section class="row wh-75 justify-content-center mt-5">
            <article class="col-12 col-md-6 me-5">
                <form method="POST" action="{{route('register')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                     <div class="mb-3">
                        <label for="surname" class="form-label">Cognome:</label>
                        <input type="text" class="form-control" id="surname" name="surname" required>
                    </div>
                     <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="mario@rossi.com" name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password:</label>
                        <div class="">
                            <input type="password" class="form-control" id="password" name="password" >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmpassword" class="col-sm-2 col-form-label">Conferma Password:</label>
                        <div class="">
                            <input type="password" class="form-control" id="confirmpassword" name="password_confirmation" >
                        </div>
                    </div>
                    <div class="col-auto d-flex justify-content-center">
                        <a class="text-decoration-none text-dark" href="{{route('login')}}">Hai già un account? <strong style="color:#f9423a">Accedi qui!</strong></a>
                    </div>
                    <div class="col-auto box-buttons">
                       <button type="submit" class="mb-5 form-button w-50">Registrati</button>
                    </div>
                </form>
            </article>
            <article class="col-12 col-md-4 sidebar-register">
    <h5 class="text-center">I vantaggi di <strong>Presto</strong>:</h5>

    <div class="sidebar-item d-flex align-items-start mb-3">
        <div class="me-3 sidebar-icon">
            <img src="./media/register/Flash.svg" alt="Flash svg" width="32px">
        </div>
        <div>
            <p class="mb-1"><strong>Semplice</strong></p>
            <p class="small text-muted mb-0">
                Rispondi ad un annuncio con un click o chiama direttamente il venditore
            </p>
        </div>
    </div>

    <div class="sidebar-item d-flex align-items-start mb-3">
        <div class="me-3 sidebar-icon">
            <img src="./media/register/Secure.svg" alt="Secure svg" width="32px">
        </div>
        <div>
            <p class="mb-1"><strong>Sicuro</strong></p>
            <p class="small text-muted mb-0">
                Consulti solo annunci che sono stati controllati prima della pubblicazione
            </p>
        </div>
    </div>

    <div class="sidebar-item d-flex align-items-start mb-3">
        <div class="me-3 sidebar-icon">
            <img src="./media/register/LensHeart.svg" alt="LensHeart svg" width="32px">
        </div>
        <div>
            <p class="mb-1"><strong>Comodo</strong></p>
            <p class="small text-muted mb-0">
                Salvi gli annunci o le ricerche che ti interessano e li rivedi quando vuoi tu
            </p>
        </div>
    </div>

    <div class="sidebar-item d-flex align-items-start mb-3">
        <div class="me-3 sidebar-icon">
            <img src="./media/register/Sparkle.svg" alt="Sparkle svg" width="32px">
        </div>
        <div>
            <p class="mb-1"><strong>Affidabile</strong></p>
            <p class="small text-muted mb-0">
                Puoi vedere le recensioni e lasciare i tuoi feedback
            </p>
        </div>
    </div>

    <div class="sidebar-item d-flex align-items-start">
        <div class="me-3 sidebar-icon">
            <img src="./media/register/Leaf.svg" alt="Leaf svg" width="32px">
        </div>
        <div>
            <p class="mb-1"><strong>Sostenibile</strong></p>
            <p class="small text-muted mb-0">
                Comprando e vendendo usato ci guadagni tu e anche il pianeta
            </p>
        </div>
    </div>
</article>

        </section>
    </main>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-layout>