<x-layout>
    <h1 class="text-center mt-5">Pagina Login:</h1>
    <main class="container">
        <section class="row wh-75 justify-content-center mt-5">
            <article class="col-12 col-md-8">
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
                    <div class="col-auto d-flex justify-content-between align-items-center">
                        <a href="{{route('register')}}">Non sei ancora registrato? Clicca qui!</a>
                        <button type="submit" class="btn btn-primary mb-3">Login</button>
                    </div>
                </form>
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