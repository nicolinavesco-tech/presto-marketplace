<x-layout>
    <h1 class="text-center pt-3 pb-5">Pagina amministratore</h1>
    <div class="container-admin">
        <div class="container text-center">
            {{-- <div class="col-12"> --}}
    
    @foreach($users as $user)
    <h4 class="mb-3">Richiesta dal utente: <strong>{{$user->name}}</strong></h4>
    <a class="btn btn-success mb-5" href="{{route("make.revisor", compact("user") )}}">
        Accetta
    </a>
    @endforeach
    </div>
    </div>
    </div>
</x-layout>