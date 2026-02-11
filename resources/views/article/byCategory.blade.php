<x-layout>
    <main class="container">
        <section class="row">
            <article class="col-12">
                <h1 class="text-center mt-5">{{ __('ui.categoryListings') }} <span>{{$category->name}}</span></h1>
            </article>
        </section>
        <section class="row mt-5">
            @forelse ($articles as $article)
                <div class="col-12 col-md-4">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12 text-center">
                    <h3>{{ __('ui.noListings') }}</h3>
                    @auth
                        <a href="{{route("article_create")}}" class="btn btn-dark my-5">{{ __('ui.postAd') }}</a>
                    @endauth
                </div>
            @endforelse
        </section>
    </main>
</x-layout>