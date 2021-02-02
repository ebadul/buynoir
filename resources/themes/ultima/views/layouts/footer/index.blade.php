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
                <p class="mb-2 mb-sm-0 text-center text-sm-left">Copyright 2020 Ultima Themes</p>
            </div>
            <div class="col-sm-6 text-center text-sm-left text-sm-right">
                <a href="#">Terms and conditions</a>
                <span class="separator mx-2">|</span>
                <a href="#">Privacy policy</a>
            </div>
        </div>
    </div>
</div>