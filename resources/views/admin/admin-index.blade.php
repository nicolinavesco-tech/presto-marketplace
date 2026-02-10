<x-layout>
    <h1>Pagina amministratore</h1>
    @foreach($users as $user)
    <p>{{$user->name}}</p>
    <a class="btn btn-success" href="{{route("make.revisor", compact("user") )}}">
        Accetta
    </a>
    @endforeach
</x-layout>