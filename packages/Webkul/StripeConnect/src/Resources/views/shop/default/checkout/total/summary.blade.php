<div class="order-summary">
    <h3>{{ __('shop::app.checkout.total.order-summary') }}</h3>

    <div class="item-detail">
        <label>
            {{ intval($cart->items_qty) }}
            {{ __('shop::app.checkout.total.sub-total') }}
            {{ __('shop::app.checkout.total.price') }} 
        </label>
        <label class="right">{{ core()->currency($cart->base_sub_total) }}</label>
    </div>

    @if ($cart->selected_shipping_rate)
        <div class="item-detail">
            <label>{{ __('shop::app.checkout.total.delivery-charges') }}</label>
            <label class="right">{{ core()->currency($cart->selected_shipping_rate->base_price) }}</label>
        </div>
    @endif

    @if ($cart->base_tax_total)
        @foreach (Webkul\Tax\Helpers\Tax::getTaxRatesWithAmount($cart, true) as $taxRate => $baseTaxAmount )
        <div class="item-detail">
            <label id="taxrate-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ __('shop::app.checkout.total.tax') }} {{ $taxRate }} %</label>
            <label class="right" id="basetaxamount-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ core()->currency($baseTaxAmount) }}</label>
        </div>
        @endforeach
    @endif

    <div class="item-detail" id="discount-detail" @if ($cart->base_discount_amount && $cart->base_discount_amount > 0) style="display: block;" @else style="display: none;" @endif>
        <label>
            {{ __('shop::app.checkout.total.disc-amount') }}
        </label>
        <label class="right">
            -{{ core()->currency($cart->base_discount_amount) }}
        </label>
    </div>

    @if ( core()->getConfigData('sales.paymentmethods.stripe.fees') == 'customer' && isset($cart->payment) && $cart->payment->method == 'stripe')
        <div class="item-detail">
            @php
                $applicationFee = $cart->base_grand_total;
                $applicationFee = (0.029 * $applicationFee) + (0.02 * $applicationFee) + 0.3;
            @endphp

            <label>
                {{ __('stripe_saas::app.shop.checkout.total.transaction-fee') }}
            </label>

            <label class="right">{{ core()->currency($applicationFee) }}</label>
        </div>
    @endif


    <div class="payable-amount" id="grand-total-detail">
        <label>{{ __('shop::app.checkout.total.grand-total') }}</label>
        <label class="right" id="grand-total-amount-detail">
            @if (core()->getConfigData('sales.paymentmethods.stripe.fees') == 'customer' && isset($cart->payment) && $cart->payment->method == 'stripe')
                {{ core()->currency($cart->base_grand_total + $applicationFee) }}
            @else
                {{ core()->currency($cart->base_grand_total) }}
            @endif
        </label>
    </div>
</div>