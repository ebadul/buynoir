<div class="footer">
    @include('ultima::home.newsletter-signup')
    <div class="container">
        <div class="footer-content">

            @include('shop::layouts.footer.footer-links')

            @if (core()->getConfigData('general.content.footer.footer_toggle'))
                @include('shop::layouts.footer.copy-right')
            @endif

            @include('ultima::layouts.footer.footer-bottom-row')
        </div>
    </div>
</div>
{{-- @todo: Make configurable --}}
<div class="footer-copyright w-100 alert alert-dark mb-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p class="mb-2 mb-sm-0 text-center text-sm-left">Copyright 2020 BuyNoir</p>
            </div>
            <div class="col-sm-6 text-center text-sm-left text-sm-right">
                <a href="#">Terms and conditions</a>
                <span class="separator mx-2">|</span>
                <a href="#">Privacy policy</a>
            </div>
        </div>
    </div>
</div>

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