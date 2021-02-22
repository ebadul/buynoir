@php
    // @todo: Figure out available methods (if CC -> add visa / mc / amex)
    $supportedImages = [
    'paypal_standard'
    ];
@endphp
<div class="payment-methods">
    @foreach(\Webkul\Payment\Facades\Payment::getPaymentMethods() as $method)
        @if(in_array($method['method'], $supportedImages))
            <div>
				<a href='https://paypal.com'>
					<img src="{{ url('/themes/ultima/assets/images/payments/' . $method['method'] . '.png') }}" loading="lazy" />
				</a>
            </div>
        @endif
    @endforeach
</div>