<x-layout>

    @if(session()->has("message"))
    <div class="row justify-content-center">
        <div class="col-5 alert alert-success text-center shadow rounded">
            {{session("message")}}
        </div>
    </div>
    @endif
    
    <div class="container-fluid pt-3">

        <div class="row">
                <h1 class="text-center pb-3">
                    Revisor dashboard
                </h1>
        </div>
        @if ($article_to_check)
        <div class="row justify-content-center pt-5">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    @for ($i = 0; $i < 6; $i++)
                    <div class="col-6 col-md-4 mb-4 text-center">
                        <img src="https://picsum.photos/300" alt="immagine segniaposto" class="img-fluid rounded shadow">
                    </div>
                    @endfor
                </div>
            </div>
            <div class="col-md-4 d-flex flex-column justify-content-evenly align-items-center">
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
                        <button class="btn btn-danger py-2 px-5 fw-bold">
                            Rifiuta
                        </button>
                    </form>
                    
                    <form action="{{route("accept", ["article"=>$article_to_check])}}" method="POST">
                        @csrf
                        @method("PATCH")
                        <button class="btn btn-success py-2 px-5 fw-bold">
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
                        <strong>Nessun articolo da revisionare</strong>
                    </h4>
                    <div class="col-auto box-buttons">
                    <a href="{{route('home')}}" class="mb-5 form-button">Torna all'homepage</a>
                    </div>
                </div>
            </div>

    @endif
</div>
</x-layout>
