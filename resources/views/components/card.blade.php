<div class="card card-w shadow mb-3 d-flex flex-column align-items-center card-welcome">

    
    <img src="{{ $article->images->isNotEmpty() ? $article->images->first()->getUrl(1000, 1000) : 'https://picsum.photos/200' }}" class="card-img-top" alt="Immagine dell'articolo {{ $article->title }}">
    <div class="card-body d-flex flex-column align-items-center text-center">

        <h4 class="card-title">{{$article->title}} </h4>
        <h6 class="card-subtitle text-body-secondary">{{$article->price}} €</h6>
        <a href="{{route('byCategory', ['category'=>$article->category])}}"
            class=" btn-outline fst-italic text-muted custom-color categoryBtn text-center flex-fill">
            {{$article->category->name}}
        </a>
        <div class="card-actions mt-auto">

            <a href="{{route('article_show', compact('article'))}}"
                class="btnCard text-center fw-bold btn text-white flex-fill">
                {{ __('ui.details') }}
            </a>


        </div>


    </div>


</div>