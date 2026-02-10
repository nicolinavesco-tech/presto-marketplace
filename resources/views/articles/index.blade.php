<x-layout>
    <div class="container-fluid your-articles-container">
        <div class="row height-custum justify-content-center align-items-center m-0">
            
            <div class="col-12 mt-3 ps-1">
                <h1 class="text-center mt-5">I tuoi annunci</h1>
                
            </div>
            
        </div>
        <div class="articles-grid mt-5">
            @forelse ($articles as $article)
            <div >
                <x-card :article="$article"/>
            </div>
            @empty
            <div class="no-item-container mx-0 text-center mt-5">
                <div class="col-12 text-center">
                    <img src="{{ asset('media/no-articles-icon.svg') }}" alt="" class="no-item-icon">
                </div>
                
                <div class="col-12">
                    <h6 class="text-center">
                        <strong>Non hai annunci online</strong>
                    </h6>
                    <p class="text-center">
                        Comincia a vendere. Ci guadagni tu e ci guadagna anche il pianeta.
                    </p>
                    <div class="col-auto box-buttons">
                    <a href="{{route('article_create')}}" class="mb-5 form-button">Inserisci annuncio</a>
                    </div>
                </div>
            </div>
            
            @endforelse
            
        </div>
        
        
    </div>
    
    <div class="d-flex justify-content-center">
        <div>
            {{$articles->links()}}
        </div>
        
    </div>
    
</x-layout>