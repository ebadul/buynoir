   <!-- Start header -->
   <header class="header-nav-center no_blur header__workspace header_software" id="myNavbar">
    <div class="container">
      <!-- navbar -->
      <nav class="navbar navbar-expand-lg navbar-light px-sm-0">
        <a class="navbar-brand" href="{{route('buynoir.home.index')}}">
          <img sizes="16x16" src="{{ asset('vendor/webkul/ui/assets/images/logo.png') }}" />
        </a>

        <button class="navbar-toggler menu ripplemenu" type="button" data-toggle="collapse"
          data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <svg viewBox="0 0 64 48">
            <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
            <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
            <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
          </svg>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto nav-pills">
           
            {{-- <li class="nav-item">
              <a class="nav-link" href="#Features">Features</a>
            </li> --}}
            {{--  <li class="nav-item">
              <a class="nav-link" href="#Integrations">Integrations</a>
            </li>  --}}
           

          </ul>
          <div class="nav_account btn_demo3">
            <button type="button" class="btn btn_sm_primary opacity-1 sweep_letter scale sweep_top rounded-8" style="background-color: rgba(170, 83, 82, .5);">
              <div class="inside_item">
                 <a href="{{route('company.create.index')}}" class="topbar-signup-link home-signup-btn" >
                  <span data-hover="Free">Sign Up</span>
                </a>
              </div>
            </button>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>
    <!-- end container -->
  </header>
  <!-- End header -->