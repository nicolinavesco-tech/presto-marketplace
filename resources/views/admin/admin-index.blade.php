<x-layout>
    <h1 class="text-center pt-3 pb-5">{{ __('ui.adminPanel') }}</h1>
    <div class="container-admin">
        <div class="container text-center">
            {{-- <div class="col-12"> --}}
    
    @foreach($users as $user)
    <h4 class="mb-3">{{ __('ui.userRequest') }} <strong>{{$user->name}}</strong></h4>
    <a class="btn btn-success mb-5" href="{{route("make.revisor", compact("user") )}}">
        {{ __('ui.accept') }}
    </a>
    <a class="btn btn-danger mb-5" href="{{route("reject.revisor", compact("user") )}}">
        {{ __('ui.reject') }}
    </a>
    @endforeach
    </div>
    </div>
    </div>
</x-layout>