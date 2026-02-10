<x-layout>
    <div>
        <div class="row py-3 justify-content-center align-items-center text-center">
            <div class="col-12">
                <h1>Risultati per la ricerca "<span class="fst-italic">{{$query}}</span>"</h1>
            </div>
        </div>
        <div class="row justify-content-center align-items-center pb-3">
            @forelse($articles as $article)
                <div class="col-12 col-md-4">
                    <x-card :article="$article" />
                </div>
            @empty

                <div class="row justify-content-center align-items-center height-custom text-center no-item-container mx-0">
                <div class="col-12 text-center">
                    <img src="{{ asset('media/searched-no-items.png') }}" alt="" class="no-item-icon">
                </div>
                
                <div class="col-12">
                    <h4 class="text-center">
                        <strong>Nessun articolo corrisponde alla tua ricerca</strong>
                    </h4>
                    <div class="col-auto box-buttons">
                    <a href="{{route('home')}}" class="mb-5 form-button">Torna all'homepage</a>
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