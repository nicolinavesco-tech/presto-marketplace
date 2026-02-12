<form action ="{{route('setLocale', $lang)}}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="flags d-flex rounded-circle">
        <img src="{{asset('vendor/blade-flags/country-'.$lang.'.svg')}}" width="25" height="30" alt="bandiera">
    </button>

</form>