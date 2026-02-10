<x-layout>
    <main class="">
        <div class="row justify-content-center">
            <div class="col-12 text-center pt-5">
                <h1>Inserisci il tuo annuncio in pochi minuti</h1>
                <p>Vendi online quello che non usi più e comincia a guadagnare</p>
            </div>
        </div>
        <section class="container mt-5 add-article-wrapper position-relative" style="background-image: url('{{ asset('media/bg_create_article_3.png') }}');">
            <div class="row justify-content-center">
                <article class="col-12 text-center pt-2">
                    {{-- <h1>Inserisci il tuo annuncio in pochi minuti</h1>
                    <p>Vendi online quello che non usi più e comincia a guadagnare</p> --}}
                </article>
                <div class="row justify-content-center align-items-center height-custom add-form">
                    <div class="col-12 col-md-6">
                        <livewire:create-article-form />
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layout>