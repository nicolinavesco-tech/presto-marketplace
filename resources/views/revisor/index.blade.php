<x-layout>

    @if(session()->has("message"))
    <div class="row justify-content-center text-center">
        <div class="alert alert-success text-center shadow rounded">
            {{session("message")}}
        </div>
    </div>
    @endif

    <div class="container-fluid pt-3">
        <div class="row">
            <h1 class="text-center pb-3">
                {{ __('ui.revisorDashboard') }}
            </h1>
        </div>
        @if ($article_to_check)
        <div class="row pt-5 ">
            <div class="col-12 col-md-6 d-flex">
                <div class="row">
                    @if ($article_to_check->images->count())
                    @foreach ($article_to_check->images as $key => $image)
                    <div class="row justify-content-end gap-3 mb-4 ">
                        <div class="col-12 col-md-6 d-flex justify-content-end">
                            <img src="{{ $image->getUrl(1000, 1000) }}"
                                class="img-fluid rounded shadow"
                                alt="Immagine {{ $key +1 }} dell'articolo '{{ $article_to_check->title }}'">
                        </div>
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-center w-25">
                                <h5 class="mb-3">Labels</h5>
                                @if ($image->labels)
                                @foreach ($image->labels as $label)
                                #{{$label}},
                                @endforeach
                                @else
                                <p class="fst-italic text-muted mb-3">No labels</p>
                                @endif
                                <h5 class="mt-3">Ratings</h5>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2 {{$image->adult}}">
                                    </div>
                                    <span>adult</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2 {{$image->violence}}">
                                    </div>
                                    <div class="col-10">violence</div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                        <div class="me-2 {{$image->spoof}}">
                                    </div>
                                    <div class="col-10">spoof</div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                        <div class="me-2 {{$image->racy}}">
                                        </div>
                                    <div class="col-10">racy</div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2 {{$image->medical}}">
                                    </div>
                                    <div class="col-10">medical</div>
                                </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col-6 col-md-4 mb-4 text-center">
                        <img src="https://picsum.photos/300"
                            alt="immagine segnaposto"
                            class="img-fluid rounded shadow">
                </div>
                @endfor
                @endif
            </div>
        </div>
        <div class="col-6 d-flex flex-column justify-content-evenly align-items-center">
            <div class="w-75 text-center mt-5">
                <h3>{{ $article_to_check->title }}</h3>
                <h4>{{ $article_to_check->user->name }}</h4>
                <h4>{{ $article_to_check->price }}€</h4>
                <h4 class="fst-italic text-muted">
                    {{ $article_to_check->category->name }}
                </h4>
                <p class="fs-6 mt-5">{{ $article_to_check->description }}</p>
            </div>

            <div class="d-flex pb-4 gap-3 justify-content-center">
                <form action="{{route("reject", ["article"=>$article_to_check])}}" method="POST">
                    @csrf
                    @method("PATCH")
                    <button type="submit" class="btn btn-cancel py-2 px-5 fw-bold">
                        Rifiuta
                    </button>
                </form>

                <form action="{{route("accept", ["article"=>$article_to_check])}}" method="POST">
                    @csrf
                    @method("PATCH")
                    <button type="submit" class="btn btn-accept py-2 px-5 fw-bold">
                        Accetta
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
    @else
    <div class="row justify-content-center align-items-center height-custom text-center no-item-container mx-0">
        <div class="col-12 text-center">
            <img src="{{ asset('media/no-articles-to-revise-2.png') }}" alt="" class="no-item-icon">
        </div>

        <div class="col-12">
            <h4 class="text-center">
                <strong>{{ __('ui.noListingsToReview') }}</strong>
            </h4>
            <form action="{{route("unDo", ["value"=> null])}}" method="POST">
                @csrf
                @method("PATCH")
                <button type="submit" class="btn btn-cancel-revisor text-white py-2 px-5 fw-bold mt-5"> {{ __('ui.undoLastReview') }}
                </button>
            </form>
            <div class="col-auto box-buttons">
                <a href="{{route('home')}}" class="mb-5 form-button mt-4">{{ __('ui.returnHome') }}</a>
            </div>
        </div>
    </div>

    @endif
    </div>
</x-layout>