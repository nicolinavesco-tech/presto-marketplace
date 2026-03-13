<x-layout>
    <div class="container">
        <div class="row height-custom justify-content-center align-items-center text-center">
            <div class="col-12">
                <h1 class="display-5 mt-5">{{ __('ui.listingDetailsTitle') }}: {{$article->title}}</h1>
            </div>
        </div>
        <div class="row height-custom justify-content-center py-5">
            <div class="col-12 col-md-6 mb3">
                @if ($article->images->count() > 0)

                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        @foreach ($article->images as $key => $image)
                        <div class="carousel-item @if ($loop->first) active @endif">
                            <img src="{{ $image->getUrl(1000, 1000) }}"
                                class="d-block w-100 rounded shadow"
                                alt="Immagine {{ $key + 1 }} dell'articolo {{ $article->title }}">
                        </div>
                        @endforeach
                    </div>
                    @if ($article->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <i class="fa-solid fa-chevron-left fa-2x text-white"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <i class="fa-solid fa-chevron-right fa-2x text-white"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif

                </div>
                @else
                <img src="https://picsum.photos/300" alt="Nessuna foto inserita dall'utente">
                @endif
            </div>
            <div class="col-12 col-md-6 mb-3 height-custom text-center">
                <h2 class="mt-5"><span class="fw-bold">{{ __('ui.fieldTitle') }}:</span> {{$article->title}}</h2>
                <div class="d-flex flex-column justify-content-center h-50 mt-5">
                    <h5 class="mt-5">{{ __('ui.fieldDescription') }}:</h5>
                    <p class="mt-3">{{$article->description}}</p>
                    <h4 class="fw-bold mt-5">{{ __('ui.fieldPrice') }}: {{$article->price}} €</h4>
                    @if(Auth::check() && Auth::user()->id == $article->user->id)

                    <div class="d-flex gap-3 justify-content-center align-items-center mt-5">

                        <form action="{{ route('article_destroy', compact('article')) }}" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-custom text-white">
                                <i class="fa-regular fa-trash-can"></i> {{ __('ui.deleteAction') }}
                            </button>
                        </form>

                        <a href="{{ route('article_edit', compact('article')) }}"
                            class="modify-button d-flex align-items-center justify-content-center">
                            {{ __('ui.editAction') }}
                        </a>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>