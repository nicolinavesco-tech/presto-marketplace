<x-layout>
    <h1 class="text-center mt-5">Pagina di registrazione</h1>
    <main class="container">
        <section class="row wh-75 justify-content-center mt-5">
            <article class="col-12 col-md-8">
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
                    <div class="col-auto d-flex justify-content-between align-items-center">
                        <a href="{{route('login')}}">Se hai già un account! Accedi qui!</a>

                       <button type="submit" class="btn btn-primary mb-3">Registrati</button>
                    </div>
                </form>
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