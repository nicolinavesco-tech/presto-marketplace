<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <h1 class="text-center">{{ __('ui.workRequestMessage') }}</h1>
        <h2>{{ __('ui.userDetailsLabel') }}</h2>
        <p>{{ __('ui.firstName') }}: {{$user->name}} </p>
        <p>{{ __('ui.emailLabel') }}:{{$user->email}} </p>
        <p>{{ __('ui.makeRevisor', ['name' => $user->name]) }}</p>
        <a href="{{ route('make.revisor', compact ('user'))}}">{{ __('ui.grantRevisorRole') }}</a>
    </div>
    
</body>

</html>