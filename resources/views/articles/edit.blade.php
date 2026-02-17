<x-layout>
    <main class="container">
        <section class="row">
            <article class="col-12 text-center">
                <h1>Modifica articolo</h1>
            </article>
            <article>
                <livewire:article-update-form :article="$article"/>
            </article>
        </section>
    </main>
</x-layout>