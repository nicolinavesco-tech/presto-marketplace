<x-layout>
    
    <main class="container">
        <section class="row wh-75 justify-content-center ">
            <article class="col-12 col-md-6 me-5 mt-5 registerSection">
                <h5 class="text-left"><strong>{{ __('ui.signUp') }}</strong></h5>
                <p class="text-left">
                    {{ __('ui.registerIntro') }} 
                </p>
                <form method="POST" action="{{route('register')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('ui.firstName') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">{{ __('ui.lastName') }}</label>
                        <input type="text" class="form-control" id="surname" name="surname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('ui.emailLabel') }}</label>
                        <input type="email" class="form-control" id="email" placeholder="mario@rossi.com" name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="col-sm-2 col-form-label">{{ __('ui.passwordLabel') }}</label>
                        <div class="">
                            <input type="password" class="form-control" id="password" name="password" >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmpassword" class="col-sm-2 col-form-label">{{ __('ui.confirmPassword') }}</label>
                        <div class="">
                            <input type="password" class="form-control" id="confirmpassword" name="password_confirmation" >
                        </div>
                    </div>
                    <div class="col-auto d-flex justify-content-center">
                        <a class="text-decoration-none text-dark" href="{{route('login')}}"> {{ __('ui.alreadyAccount') }} <strong style="color:#f9423a">{{ __('ui.loginHere') }}</strong></a>
                    </div>
                    <div class="col-auto box-buttons">
                        <button type="submit" class="mb-5 form-button w-50">{{ __('ui.signUp') }}</button>
                    </div>
                </form>
            </article>
            <article class="col-12 col-md-4 sidebar-register mt-5">
                <h5 class="text-left mb-4 p-2"><strong>{{ __('ui.prestoAdvantages') }}</strong>:</h5>
                
                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="./media/register/Flash.svg" alt="Flash svg" width="32px">
                    </div>
                    <div>
                        <p class="mb-1"><strong>{{ __('ui.simple') }}</strong></p>
                        <p class="small text-muted mb-0">
                            {{ __('ui.simpleDesc') }}
                        </p>
                    </div>
                </div>
                
                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="./media/register/Secure.svg" alt="Secure svg" width="32px">
                    </div>
                    <div>
                        <p class="mb-1"><strong>{{ __('ui.reliable') }}</strong></p>
                        <p class="small text-muted mb-0">
                            {{ __('ui.secureDesc') }}
                        </p>
                    </div>
                </div>
                
                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="./media/register/LensHeart.svg" alt="LensHeart svg" width="32px">
                    </div>
                    <div>
                        <p class="mb-1"><strong>{{ __('ui.convenient') }}</strong></p>
                        <p class="small text-muted mb-0">
                            {{ __('ui.saveDesc') }}
                        </p>
                    </div>
                </div>
                
                <div class="sidebar-item d-flex align-items-start mb-3">
                    <div class="me-3 sidebar-icon">
                        <img src="./media/register/Sparkle.svg" alt="Sparkle svg" width="32px">
                    </div>
                    <div>
                        <p class="mb-1"><strong>{{ __('ui.reliable') }}</strong></p>
                        <p class="small text-muted mb-0">
                            {{ __('ui.reviewsDesc') }}
                        </p>
                    </div>
                </div>
                
                <div class="sidebar-item d-flex align-items-start">
                    <div class="me-3 sidebar-icon">
                        <img src="./media/register/Leaf.svg" alt="Leaf svg" width="32px">
                    </div>
                    <div>
                        <p class="mb-1"><strong>{{ __('ui.sustainable') }}</strong></p>
                        <p class="small text-muted mb-0">
                            {{ __('ui.sustainableDesc') }}
                        </p>
                    </div>
                </div>
            </article>
            
        </section>
    </main>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</x-layout>