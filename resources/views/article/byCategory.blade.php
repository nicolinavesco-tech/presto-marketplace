<x-layout>
    <main class="container">
        <section class="row">
            <article class="col-12">
                <h1>Articoli della categoria <span>{{$category->name}}</span></h1>
            </article>
        </section>
        <section class="row">
            @forelse ($articles as $article)
                <div class="col-12 col-md-3">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12 text-center">
                    <h3>Non sono ancora stati creati articoli per questa categoria!</h3>
                    @auth
                        <a href="{{route("create.article")}}" class="btn btn-dark my-5">Pubblica un articolo</a>
                    @endauth
                </div>
            @endforelse
        </section>
    </main>
</x-layout>