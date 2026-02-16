<x-layout>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center pt-5">
                <h1>{{ __('ui.heroTitle') }}</h1>
                <p>{{ __('ui.heroSubtitle') }}</p>
            </div>
        </div>

        <section class="mt-5 add-article-wrapper position-relative">
            <div class="row justify-content-center align-items-center height-custom add-form">
                <div class="col-12 col-md-6">
                    <livewire:create-article-form />
                </div>
            </div>

        </section>
    </main>
</x-layout>