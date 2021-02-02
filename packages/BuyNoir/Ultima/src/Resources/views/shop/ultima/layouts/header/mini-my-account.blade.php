<div class="mini-my-account">
    <p>
        {{ __('velocity::app.header.welcome-message', ['customer_name' => auth()->guard('customer')->user()->first_name]) }}
    </p>
    <div class="text-center mb-2">
        <a href="{{ url('customer/account/profile') }}" class="btn w-100">My Account</a>
    </div>
    <div class="text-center">
        <a href="{{ route('customer.session.destroy') }}" class="btn btn-outline w-100 unset pull-right">
            {{ __('shop::app.header.logout') }}
        </a>
    </div>
</div>