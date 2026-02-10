<x-layout>
    <div class="container">
        <div class="row height-custom justify-content-center align-items-center text-center">
            <div class="col-12">
                <h1 class="display-5 mt-5">Dettaglio dell'articolo: {{$article->title}}</h1>
            </div>
        </div>
        <div class="row height-custom justify-content-center py-5">
            <div class="col-12 col-md-6 mb3">
                
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://picsum.photos/400" class="d-block w-100 " alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/400" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/400" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <i class="fa-solid fa-chevron-left fa-2x text-white"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <i class="fa-solid fa-chevron-right fa-2x text-white"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3 height-custom text-center">
                <h2 class="mt-5"><span class="fw-bold">Titolo:</span> {{$article->title}}</h2>
                <div class="d-flex flex-column justify-content-center h-50 mt-5">
                    <h5 class="mt-5">Descrizione:</h5>
                    <p class="mt-3">{{$article->description}}</p>
                    <h4 class="fw-bold mt-5">Prezzo: {{$article->price}} €</h4>
                    @if(Auth::check() && Auth::user()->id == $article->user->id)
                    
                    <form action="{{route('article_destroy', compact('article'))}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-custom text-white mt-5"><i class="fa-regular fa-trash-can"></i>  Elimina</button>
                        
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>