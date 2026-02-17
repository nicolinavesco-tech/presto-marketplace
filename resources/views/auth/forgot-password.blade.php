<x-layout>
<h1>Password dimenticata</h1>

@if (session('status'))
<div class="status-message-resend-password">
    {{ __('ui.reset_link_sent') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">{{ __('ui.emailLabel') }}</label>
        <input type="email" class="form-control" id="email" placeholder="mario@rossi.com" name="email" >
    </div>

    @error('email')
        <div>{{ $message }}</div>
    @enderror
    <div class="col-auto box-buttons">
        <button type="submit" class="mb-3 form-button w-50">{{ __('ui.login') }}</button>
    </div>
</form>

<div class="mt-3 mb-5 text-center">
    <a href="{{ route('login') }}"><i class="bi bi-arrow-return-left me-1"></i>Torna al Login</a>
  </div>


</x-layout>