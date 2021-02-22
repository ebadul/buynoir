   <!-- Start footer -->
   <footer class="footer_short position-relative bg-white z-index-3">
    <div class="container">
      <div class="row justify-content-md-center text-center">
        <div class="col-md-8">
          <a class=" c-dark" href="">
            <!-- <img src="assets/img/logo.svg" alt=""> -->
            <img  src="{{ asset('vendor/webkul/ui/assets/images/logo.png') }}" />
          </a>
          <div class="social--media">
            <a href="https://www.instagram.com/buynoir_official/" class="btn so-link" target="_blank" rel="noreferrer">
              <i class="tio instagram"></i>
            </a>
            <a href="https://twitter.com/NoirBuy" class="btn so-link" target="_blank" rel="noreferrer" class="btn so-link">
              <i class="tio twitter"></i>
            </a>
            <a href="https://www.facebook.com/BuyNoirApp/" class="btn so-link" target="_blank" rel="noreferrer">
              <i class="tio facebook_square"></i>
            </a>
          </div>
          <div class="other--links">
            <a href="{{route("buynoir.home.contactus")}}">Support</a>
            <a href="{{route("buynoir.home.privacypolicy")}}">Privacy Policy</a>
            <a href="#">Cookie Policy</a>
          </div>
          <div class="opyright">
            <p>
              © 2020
              <a href="https://buynoir.co" target="_blank">BuyNoir</a>
              All Right Reseved
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
  <!-- Login Modal  -->
  <div class="modal mdllaccount fade" id="mdllLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="tio clear"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="form_account">
            <div class="head_account">
              <div class="img_profile">
                <img src="{{ asset('buynoir/landingpage/assets/img/buy-logo-small.png')}}" />
              </div>
              <div class="title">
                <h4>BuyNoir.</h4>
                <p>
                  Welcome back <br />
                  ✊🏾
                </p>
              </div>
            </div>
            <div class="form-row">
              <div class="col-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Email / Username</label>
                      <input type="email" class="form-control" placeholder="E-mail / Username" />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group mb-1 --password" id="show_hide_password">
                      <label>Password</label>
                      <div class="input-group">
                        <input type="password" class="form-control" data-toggle="password" placeholder="Password"
                          required="" />
                        <div class="input-group-prepend hide_show">
                          <a href=""><span class="input-group-text tio hidden_outlined"></span></a>
                        </div>
                      </div>
                    </div>
                    <a href="#" class="btn mt-2 font-s-12 font-w-400 c-gray p-0">Forgot Passowrd?</a>
                  </div>
                  <div class="col-12 mt-4">
                    <a href="#" class="btn rounded-6 btn_xl_primary btn_login bg-green2">Sign in</a>
                    <a href="{{route('company.create.index')}}" class="btn mt-3 font-s-15 c-dark text-center w-100">Create new account</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End. Modal -->

  <!-- Back to top with progress indicator-->
  <div class="prgoress_indicator" id="prgoress_indicator" onclick='navTo()'>
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>

  <!-- Tosts -->
  {{--  <div aria-live="polite" aria-atomic="true"  class="d-flex justify-content-center align-items-center">
    <div class="toast toast_demo" id="myTost" role="alert" aria-live="assertive" aria-atomic="true"
      data-animation="true" data-autohide="false">
      <div class="toast-body" id="cookieconsent">
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <i class="tio clear"></i>
        </button>
        <h5>Hey fam ✊🏾! </h5>
        <p>We use cookies throughout this site to make your experience better. <a href="#">Ok?</a></p>

        <div id="consent-popup" class="hidden">
          <p>By using this site you agree to our <a href="#">Terms and Conditions</a>.
              Please <a id="accept" href="#">Accept</a> these before using the site.
          </p>
      </div>

      </div>
    </div>
  </div>  --}}
  <!-- End. Toasts -->

  <!-- Start Section Loader -->
    @if( request()->is('index') )
      <section class="loading_overlay">
        <div class="loader_logo">
          <!-- <img class="logo" src="assets/img/logo.svg" /> -->
          <span class="logo">Made in ATL!</span>
        </div>
      </section>
    @endif
      <!-- End. Loader -->
 

 
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
  <script>
          function navTo(){
            window.scrollTo({
              top: 0,
              behavior: 'smooth'   
            });
          }
           
          window.addEventListener("load", function(){
          window.cookieconsent.initialise({
            "palette": {
                "popup": {
                  "background": "#000"
                },
                "button": {
                  "background": "#f1d600"
                },
              },
            content: {
              header: 'Cookiessss used on the website!',
              message: 'We use cookies throughout this site to make your experience better.',
              dismiss: 'Got it!',
              allow: 'Allow cookies',
              deny: 'Decline',
              link: 'Learn more',
              href: 'http://buynoir.co',
              close: '&#x274c;',
            }
          })});
  </script>
     