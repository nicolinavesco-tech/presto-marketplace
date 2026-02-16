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
    <!-- Header con la barra di ricerca -->
    <header class="container-fluid text-center">
        <div class="row row-home ">
            <form action="{{route('article.search')}}" method="GET">
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
                                    {{ __('ui.categories') }} <i class="fa-solid fa-chevron-down" style="color: rgba(237, 46, 46, 0.54);"></i>
                                </button>
                                <div class="collapse collapseCategorie mt-5 text-center" id="collapseCategorie">
                                    <div class="form-check">
                                        <ul class="list-unstyled me-4">
                                            @foreach($categories as $category)
                                            <li>
                                                <a href=" {{route ('byCategory', compact('category'))}}" class="dropdown-item text-capitalize">{{$category->name}} </a>
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
        <div class="d-none d-md-flex gap-4 mt-2 justify-content-center fidelity-message">
            <span class="font-message"><i class="fa-solid fa-check" style="color: #2E7D32;"></i> {{ __('ui.overListings') }}</span>
            <span class="font-message"><i class="fa-solid fa-check" style="color: #2E7D32;"></i> {{ __('ui.securePayments') }}</span>
            <span class="font-message"><i class="fa-solid fa-check" style="color: #2E7D32;"></i>  {{ __('ui.dedicatedSupport') }}</span>
            <span class="font-message"><i class="fa-solid fa-check" style="color: #2E7D32;"></i>  {{ __('ui.verifiedCommunity') }}</span>
        </div>
    </header>
    <!-- First section -->
    <section class="container">
        <div class="row firstSection align-items-center mx-auto">
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
    <!-- Second section -->
    <section class="container  ">
        <div class="row  secondSection">
            <div class="d-flex justify-content-center flex-column text-center mt-5">

                <div class="">
                    <h4 class="fw-bold">{{ __('ui.howItWorks') }}</h4>
                    <p class="text-muted">{{ __('ui.sellOfferFind') }}</p>
                </div>

                <div class="d-flex justify-content-center gap-5 mt-3 second-section-mobile">
                    <div class="img-second-section">
                        <img src="./media/How-it-works/image1.png" alt="Immagine pubblica" class="img-fluid w-100">
                        <h5 class="fw-bold mt-4">{{ __('ui.publish') }}</h5>
                        <p class="text-muted w-75 ms-4">{{ __('ui.publishAds') }}</p>
                    </div>
                    <div class=" img-second-section">
                        <img src="./media/How-it-works/image2.png" alt="Immagine trova" class="img-fluid w-100">
                        <h5 class="fw-bold mt-4">{{ __('ui.find') }}</h5>
                        <p class="text-muted ">{{ __('ui.findNearby') }}</p>
                    </div>
                    <div class="img-second-section">
                        <img src="./media/How-it-works/image3.png" alt="Immagine guadagna" class="img-fluid w-100">
                        <h5 class="fw-bold mt-4">{{ __('ui.earn') }}</h5>
                        <p class="text-muted w-75 ms-5">{{ __('ui.closeDeal') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Third section -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-10 col-centered ">
                <h3 class="fw-semibold">{{ __('ui.highlighted_for_you') }}</h3>

                <div id="carouselExample" class="carousel slide mt-4" data-ride="carousel" data-bs-interval="2500">
                    <div class="carousel-inner">
                        @foreach($articles->chunk(4) as $slideindex => $chunk)
                        <div class="carousel-item {{ $slideindex === 0 ? 'active' : '' }}">
                            <div class="row g-3">

                                @foreach($chunk as $article)
                                <div class="col-12 col-md-6 col-xl-3">
                                    <x-card :article="$article" />
                                </div>
                                @endforeach
                            </div>

                        </div>
                        @endforeach
                    </div>
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <i class="fa-solid fa-angle-left fa-2x" style="color: rgba(237, 46, 46, 0.54);"></i>
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <i class="fa-solid fa-angle-right fa-2x" style="color: rgba(237, 46, 46, 0.54);"></i>
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>

            </div>
        </div>
    </section>
    <!-- Fourth section -->
    <section class="container mt-5">
        <div class="row">
            <div class="d-flex col-12 justify-content-center align-items-center gap-3">
                <div class="d-flex flex-column w-50">
                    <h5 class="fw-semibold">{{ __('ui.haveBusiness') }}</h5>
                    <p class="fst-italic text-muted text-mobile">{{ __('ui.sellEasy') }} <br> {{ __('ui.millionsDiscover') }}</p>
                </div>

                <div class="img-fourth-section d-flex w-25 justify-content-center gap-2">
                    <div class="d-flex flex-column align-items-center">
                        <img src="./media/Section4/firstImage.png" alt="third-section" class="img-fluid w-100 ">
                        <a href="" class="findMore">{{ __('ui.learnMore') }}</a>
                    </div>
                    <div class="d-flex flex-column align-items-center mt-2 ">
                        <img src="./media/Section4/SecondImage.png" alt="third-section" class="img-fluid w-100">
                        <a href="" class="findMore">{{ __('ui.activateNow') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fifth section -->
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center align-items-center border border-1 box-section5">
                <div class="w-25 image-section5">
                    <img src="./media/section5/imgRevisor.png" alt="third-section" class="img-fluid img-section5">
                </div>
                <div class="d-flex flex-column text-section5">
                    <h5 class="fw-semibold">{{ __('ui.eyeForDetails') }}</h5>
                    <p class="fst-italic text-muted">{{ __('ui.becomeReviewer') }}</p>
                </div>
                <div class="section5-btn">
                    <a href="" class="work-with-us">{{ __('ui.workWithUs') }}</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Sixth section -->
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-start align-items-center gap-4 content-section6">
                <div class="img-section6">
                    <img src="./media/section6/img-6-section.png" alt="Immagine fai spazio nell'armadio" class="img-fluid image-section6">
                </div>
                <div class="d-flex flex-column  ">
                    <span class="fw-bold titleSpan">Presto</span>
                    <h5 class="fw-bold">{{ __('ui.makeSpace') }}</h5>
                    <p class="text-muted">{{ __('ui.betterWithPresto') }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Seventh section -->
    <section class="container container-custom">
        <div class="row seventhSection align-items-center">
            <div class="col-12 col-md-6 d-flex flex-column ">
                <div class="d-flex justify-content-end align-items-center gap-4 me-5">
                    <h5 class="fw-bold text-white mb-5">{{ __('ui.downloadApp') }}</h5>
                    <img src="./media/section7/qr-code.png" alt="Immagine sezione 7" class="qr-code">
                </div>
                <div class="d-flex justify-content-center align-items-centerbg-warning gap-4 mt-5 ms-4">
                    <div class="d-flex flex-column">
                        <img src="./media/section7/stars.png" alt="Immagine sezione 7" class="img-fluid star">
                        <span class="text-white fw-bold">4.7 <i class="fa-brands fa-apple"></i> {{ __('ui.appStore') }}</span>
                    </div>
                    <div class="d-flex flex-column">
                        <img src="./media/section7/stars.png" alt="Immagine sezione 7" class="img-fluid star">
                        <span class="text-white fw-bold">4.7 <i class="fa-brands fa-google-play"></i> {{ __('ui.playStore') }}</span>
                    </div>
                    <div class="d-flex align-items-center ms-5 paragraph">
                        <p class="text-white">{{ __('ui.basedOnReviews') }}</p>
                    </div>


                </div>
            </div>

            <div class="col-12 col-md-6 d-flex justify-content-center">

                <img src="./media/section7/img7section.png" alt="Immagine sezione 7" class="img-fluid w-50 img7section">
            </div>



        </div>
    </section>

</x-layout>