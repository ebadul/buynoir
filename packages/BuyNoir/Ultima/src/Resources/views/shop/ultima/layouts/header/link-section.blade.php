<top-nav-links
    @auth('customer') :is-logged-in="true" @endauth
    >
    <template v-slot:login>
        <div class="sign-in p-3">
            @guest('customer')
                @include('ultima::layouts.header.login')
            @endguest

            @auth('customer')
                @include('ultima::layouts.header.mini-my-account')
            @endauth
        </div>
    </template>
    <template v-slot:minicart>
        @include('ultima::checkout.cart.mini-cart')
    </template>
</top-nav-links>