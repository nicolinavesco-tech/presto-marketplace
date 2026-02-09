<div class="card mx-auto card-w shadow mb-3 d-flex flex-column align-items-center">

    <img src="https://picsum.photos/200" class="card-img-top" alt="immagine dell' articolo {{$article->title}}">
    <div class="card-body d-flex flex-column align-items-center justify-content-between text-center">

        <h4 class="card-title">{{$article->title}} </h4>
        <h6 class="card-subtitle text-body-secondary">{{$article->price}} €</h6>
        <div class="d-flex flex-column gap-2 mt-4">

            <a href="{{route('article_show', compact('article'))}}"
            class="btnCard text-center fw-bold btn text-white flex-fill">
            Dettaglio
        </a>
            
            <a href="{{route('byCategory', ['category'=>$article->category])}}"
            class="btn btn-outline bg-light text-danger fw-bold categoryBtn text-center flex-fill">
            {{$article->category->name}}
        </a>
        
        </div>


    </div>


</div>