@if (
    $ultimaMetaData
    && $ultimaMetaData->subscription_bar_content
    || core()->getConfigData('customer.settings.newsletter.subscription')
)
    <div class="newsletter-subscription">
        <div class="newsletter-wrapper">
            @if ($ultimaMetaData && $ultimaMetaData->subscription_bar_content)
                {!! $ultimaMetaData->subscription_bar_content !!}
            @endif

            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                <div class="subscribe-newsletter">
                    <div class="form-container">
                        <form action="{{ route('shop.subscribe') }}">
                            <div class="subscriber-form-div">
                                <div class="control-group">
                                    <div class="form-group mb-3">
                                        <input
                                            type="email"
                                            name="subscriber_email"
                                            class="control subscribe-field w-100"
                                            placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                                            required />
                                    </div>

                                    <button class="theme-btn subscribe-btn fw6">
                                        {{ __('shop::app.subscription.subscribe') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
