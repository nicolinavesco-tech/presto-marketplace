<x-layout>
    <main class="container login-wrapper position-relative" style="background-image: url('{{ asset('media/bg_login_2.png') }}');">
        <div class="login-hero-text">
        <p class="hero-line-1">
           {{ __('ui.landingMainText') }}
        </p>
        <p class="hero-line-2">
            <strong> {{ __('ui.landingCta') }} </strong>
        </p>
    </div>
        <section class="row wh-75 justify-content-end align-items-end login-row">
            <article class="col-12 col-lg-4 login-article d-flex">
                <div class="login-card">
                    <h5 class="text-center"><strong>{{ __('ui.loginTitle') }}</strong></h5>
                    <p class="text-center">
                        {{ __('ui.communityText') }}
                    </p>
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('ui.emailLabel') }}:</label>
                            <input type="email" class="form-control" id="email" placeholder="mario@rossi.com" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-sm-2 col-form-label">{{ __('ui.passwordLabel') }}:</label>
                            <div>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-auto d-flex justify-content-center">
                            <a class="text-decoration-none text-dark" href="{{route('register')}}">
                                {{ __('ui.noAccount') }} <strong style="color:#f9423a">{{ __('ui.signUp') }}</strong>
                            </a>
                        </div>
                        <div class="col-auto box-buttons">
                            <button type="submit" class="mb-3 form-button w-50">{{ __('ui.login') }}</button>
                        </div>
                    </form>
                </div>
            </article>
        </section>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </main>
</x-layout>
