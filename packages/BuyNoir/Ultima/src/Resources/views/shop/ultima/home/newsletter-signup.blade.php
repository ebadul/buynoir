<div class="home-newsletter-signup-container">
    <div class="container">
        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
            <form method="post" class="home-newsletter-signup py-4" action="{{ route('shop.subscribe') }}">

                @if (
                    $ultimaMetaData
                    && $ultimaMetaData->subscription_bar_content
                )
                    {!! $ultimaMetaData->subscription_bar_content !!}
                @endif
                
                <div class="form-group">
                    <input
                        required
                        type="email"
                        name="subscriber_email"
                        placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                    />
                </div>
                
                <div class="text-center">
                    <button type="submit">{{ __('SUBSCRIBE') }}</button>
                </div>
            </form>
        @endif        
    </div>
</div>