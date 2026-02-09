<x-layout>
    <header class="container-fluid text-center">
        <div class="row row-home ">
            <div class="d-flex justify-content-center mt-5">
                <div class="col-12 col-md-6 headerForm d-flex justify-content-center gap-5">
                    <div class="d-flex flex-column align-items-center w-25 mt-3">
                        <p class="fw-bold">Cosa cerchi?</p>
                        <form action="{{route("article.search")}}" role="search" method="GET">
                            @csrf
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query"/>
                            <button type="submit">Cerca</button>
                        </form>
                    </div>
                    <div class="d-flex flex-column align-items-center w-25 mt-3">
                        <p class="fw-bold">In quale categoria?</p>
                        <div class="d-flex justify-content-center">
                            <button class="btnCategory" id="filterBtn" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseCategorie" aria-expanded="false"
                                aria-controls="collapseExample">
                                Categorie
                            </button>
                            <div class="collapse collapseCategorie mt-5 text-center" id="collapseCategorie">
                                <div class="form-check">
                                    <ul class="list-unstyled me-4">
                                        @foreach($categories as $category)
                                        <li>
                                            <a href="" class="dropdown-item text-capitalize">{{$category->name}}</a>
                                        </li>
                                        @if (!$loop->last)
                                        <hr class="dropdown-divider">
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center w-25 mt-3">
                        <p class="fw-bold">Dove?</p>
                        <form class="" role="search">
                            <input class="form-control me-2" type="search" placeholder="Tutta Italia" aria-label="Search" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>
    <section class="container">
        <div class="row firstSection align-items-center mx-auto w-75">
            <div class="col-12 d-flex justify-content-around mt-5 gap-3">
                <div class="iconBorder  w-25 d-flex justify-content-center align-items-center">
                    <div class="iconDiv d-flex align-items-center justify-content-around gap-5 transport">
                        <img src="./media/transport.png" alt="car" class="imgFirstSection">
                        <h5 class="titleTransport fw-bold">Motori</h5>
                    </div>
                </div>
                <div class="iconBorder  w-25 d-flex justify-content-center align-items-center">
                    <div class="iconDiv d-flex align-items-center justify-content-around gap-5 armchair">
                        <img src="./media/armchair.png" alt="armchair" class="imgFirstSection ">
                        <h5 class="titleArmchair fw-bold">Market</h5>
                    </div>
                </div>
                <div class="iconBorder  w-25 d-flex justify-content-center align-items-center">
                    <div class="iconDiv d-flex align-items-center justify-content-around gap-5 building">
                        <img src="./media/skyline.png" alt="building" class="imgFirstSection">
                        <h5 class="fw-bold titleBuilding">Immobili</h5>
                    </div>
                </div>
                <div class="iconBorder  w-25 d-flex justify-content-center align-items-center">
                    <div class="iconDiv d-flex align-items-center justify-content-around gap-5 briefcase">
                        <img src="./media/briefcase.png" alt="briefcase" class="imgFirstSection">
                        <h5 class="fw-bold titleBriefcase">Lavoro</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center cardSection">
            @forelse ($articles as $article)
            <div class="col-12 col-md-3 mt-5">
                <x-card :article="$article" />
            </div>
            @empty
            <div class="col-12 mt-5">
                <h3 class="text-center">
                    Non sono ancora stati creati articoli
                </h3>
            </div>
            @endforelse
        </div>
    </div>
</x-layout>