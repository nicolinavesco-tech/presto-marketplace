<!-- Footer -->
<footer class="bg-body-tertiary text-center mt-5 ">
  <!-- Grid container -->
  <div class="container p-4">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-facebook-f"></i
      ></a>

      <!-- Twitter -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-twitter"></i
      ></a>

      <!-- Google -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-google"></i
      ></a>

      <!-- Instagram -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-linkedin-in"></i
      ></a>

      <!-- Github -->
      <a data-mdb-ripple-init class="btn btn-outline btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->

    <!-- Section: Form -->
    {{-- <section class="">
      <form action="">
        <!--Grid row-->
        <div class="row d-flex justify-content-center">
          <!--Grid column-->
          <div class="col-auto">
            <p class="pt-2">
              <strong>Sign up for our newsletter</strong>
            </p>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-5 col-12">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" id="form5Example24" class="form-control" />
              <label class="form-label" for="form5Example24">Email address</label>
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-auto">
            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" class="btn btn-outline mb-4">
              Subscribe
            </button>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </form>
    </section> --}}
    <!-- Section: Form -->

    <!-- Section: Text -->
    {{-- <section class="mb-4">
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt distinctio earum
        repellat quaerat voluptatibus placeat nam, commodi optio pariatur est quia magnam eum
        harum corrupti dicta, aliquam sequi voluptate quas.
      </p>
    </section> --}}
    <!-- Section: Text -->

    <!-- Section: Links -->
    <section class="">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <ul class="list-unstyled mb-0">
            <li>
              <a class="text-body" href="#!">{{ __('ui.assistance') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.rules') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.security') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.terms') }}</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <ul class="list-unstyled mb-0">
            <li>
              <a class="text-body" href="#!">{{ __('ui.privacy') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.accessibility') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.manageCookies') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.tuttoPrestoSell') }}</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <ul class="list-unstyled mb-0">
            <li>
              <a class="text-body" href="#!">{{ __('ui.tuttoPrestoBuy') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.tuttoPrestoService') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.tuttoPrestoServiceProfessionals') }}</a>
            </li>
            <li>
              <a class="text-body" href="{{route('article_create')}}">{{ __('ui.postAd') }}</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <ul class="list-unstyled mb-0">
            <li>
              <a class="text-body" href="#!">{{ __('ui.promoteAd') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.sellingTips') }}</a>
            </li>
            <li>
              <a class="text-body" href="#!">{{ __('ui.shopsAndCompanies') }}</a>
            </li>
            <li>
              <a class="text-body" href="{{route('become.revisor')}} ">{{ __('ui.workAsReviewer') }}</a>
              
            </li>

            <li>
              <a class="text-body" href="#!">{{ __('ui.prestoForCompanies') }}</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </section>
    <!-- Section: Links -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->

  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    
    <div class="box-nav mb-2">
        <a href="" class="logo text-decoration-none text-danger">
            <img src="{{ asset('media/logo_bw.png') }}" alt="" class="logo-footer img-fluid">
        </a>
    </div>

    <p class="mb-0">
        © 2020 Copyright:
        <a class="text-reset fw-bold" href="#">Presto.it</a>
    </p>

</div>

  <!-- Copyright -->
</footer>
<!-- Footer -->

