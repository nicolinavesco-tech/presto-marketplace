<x-layout>
    <div class="container">
        <div class="row height-custom justify-content-center align-items-center text-center">
            <div class="col-12">
                <h1 class="display-4">Dettaglio dell'articolo: {{$article->title}}</h1>
            </div>
        </div>
        <div class="row height-custom justify-content-center py-5">
            <div class="col-12 col-md-6 mb3">
                <div class="splide" aria-label="Carousel">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide">
                                <img src="https://picsum.photos/800/400?1" class="img-fluid" alt="Slide 1">
                            </li>
                            <li class="splide__slide">
                                <img src="https://picsum.photos/800/400?2" class="img-fluid" alt="Slide 2">
                            </li>
                            <li class="splide__slide">
                                <img src="https://picsum.photos/800/400?3" class="img-fluid" alt="Slide 3">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3 height-custom text-center">
                <h2 class="display-5"><span class="fw-bold">Titolo:</span>{{$article->title}}</h2>
                <div class="d-flex flex-column justify-content-center h-75">
                    <h4 class="fw-bold">Prezzo: {{$article->price}} €</h4>
                    <h5>Descrizione:</h5>
                    <p>{{$article->description}}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>