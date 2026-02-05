<x-layout>
<div class="container-fluid">
<div class="row height-custum justify-content-center align-items-center text-center">

<div class="col-12">
    <h1 class=display-1> se va bene funziona
    </h1>

</div>

</div>
<div class="row height-custum justify-content-center align-items-center text-center">
@forelse ($articles as $article)
<div class="col-12 col-md-3">
    <x-card :article="$article"/>
    <span class="mt-2">{{ $article->created_at }}</span>
</div>
@empty
<div class="col-12">
    <h3 class="text-center">
        non sono ancora stati creati articoli
    </h3>
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