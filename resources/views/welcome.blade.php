<x-layout>
    @if(session()->has("errorMessage"))
    <div class="alert alert-danger text-center shadow rounded w-50">
        {{session("errorMessage")}}
    </div>
    @endif
    @if(session()->has('message'))
    <div class="alert alert-success text-center shadow rounded w-50">
        {{session('message')}}
    </div>
    @endif
        <header class="container-fluid text-center">
            <div class="row row-home ">
                <form action="{{route("article.search")}}" method="GET">
                    <div class="d-flex inputSearch justify-content-center mt-5 h-75">
                        <div class="col-12 col-md-7 headerForm d-flex justify-content-center align-items-center">
                            <div class="d-flex flex-column align-items-center ">
                                <p class="fw-bold m-0">{{ __('ui.whatSearch') }}</p>
                                <input class="form-control me-2 searchBar" type="search" placeholder="{{ __('ui.search') }}" aria-label="Search" name="query" />
                            </div>
                            <div class="d-none d-lg-flex flex-column align-items-center w-25 ">
                                <p class="fw-bold m-0">{{ __('ui.chooseCategory') }}</p>
                                <div class="d-flex justify-content-center">
                                    <button class="btnCategory" id="filterBtn" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseCategorie" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        {{ __('ui.categories') }}
                                    </button>
                                    <div class="collapse collapseCategorie mt-5 text-center" id="collapseCategorie">
                                        <div class="form-check">
                                            <ul class="list-unstyled me-4">
                                                @foreach($categories as $category)
                                                <li>
                                                    <a href=" {{route ('byCategory', compact('category'))}}" class="dropdown-item text-capitalize">{{$category->name}}</a>
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
                            <div class="d-none d-lg-flex flex-column align-items-center w-25">
                                <p class="fw-bold m-0">{{ __('ui.where') }}</p>
                                <input class="form-control me-2" type="search" placeholder="{{ __('ui.allItaly') }}" aria-label="Search" name="location" />
                            </div>
                            <div class="h-50 ms-3 search-btn-wrapper">
                                <button type="submit" class="btnSearch text-white"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
                            </div>
                        </div>
                    </div>
                </form>



            </div>
        </header>
        <section class="container">
            <div class="row firstSection align-items-center mx-auto w-75">
                <div class="col-12 d-flex justify-content-around mt-5 gap-3">
                    <div class="iconTransport w-25 d-flex justify-content-center align-items-center">
                        <div class="iconDiv d-flex align-items-center justify-content-around gap-2 gap-lg-5 transport">
                            <img src="./media/transport.png" alt="car" class="imgFirstSection">
                            <h5 class="titleTransport fw-bold">{{ __('ui.engine') }}</h5>
                        </div>
                    </div>
                    <div class="iconArmchair  w-25 d-flex justify-content-center align-items-center">
                        <div class="iconDiv d-flex align-items-center justify-content-around gap-2 gap-lg-5 armchair">
                            <img src="./media/armchair.png" alt="armchair" class="imgFirstSection ">
                            <h5 class="titleArmchair fw-bold">{{ __('ui.market') }}</h5>
                        </div>
                    </div>
                    <div class="iconBuilding w-25 d-flex justify-content-center align-items-center">
                        <div class="iconDiv d-flex align-items-center justify-content-around gap-2 gap-lg-5 building">
                            <img src="./media/skyline.png" alt="building" class="imgFirstSection">
                            <h5 class="fw-bold titleBuilding">{{ __('ui.property') }}</h5>
                        </div>
                    </div>
                    <div class="iconBriefcase w-25 d-flex justify-content-center align-items-center">
                        <div class="iconDiv d-flex align-items-center justify-content-around gap-2 gap-lg-5 briefcase">
                            <img src="./media/briefcase.png" alt="briefcase" class="imgFirstSection">
                            <h5 class="fw-bold titleBriefcase">{{ __('ui.work') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-fluid">
            <div class="articles-grid d-flex row cardSection mt-5">
                @forelse ($articles as $article)
                <div class="col-12 col-sm-6 col-lg-3 mt-5">
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