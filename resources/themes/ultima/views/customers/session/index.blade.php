@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.login-form.page-title') }}
@endsection

@section('content-wrapper')
    <div class="auth-content form-container">

        {!! view_render_event('bagisto.shop.customers.login.before') !!}

            <div class="container">
                <div class="login">
                    <div class="body">
                        <div class="form-header mb-4">
                            <h3 class="text-uppercase text-center t-l">
                                {{ __('Already Registered?')}}
                            </h3>

                            <p class="text-center text-uppercase my-5">
                                {{ __('Login with email')}}
                            </p>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('customer.session.create') }}"
                            @submit.prevent="onSubmit">

                            {{ csrf_field() }}

                            <div class="form-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <label for="email" class="mandatory label-style text-uppercase">
                                    {{ __('shop::app.customer.login-form.email') }}
                                </label>

                                <input
                                    type="text"
                                    class="form-style w-100"
                                    name="email"
                                    v-validate="'required|email'"
                                    value="{{ old('email') }}"
                                    data-vv-as="&quot;{{ __('shop::app.customer.login-form.email') }}&quot;" />

                                <span class="control-error" v-if="errors.has('email')">
                                    @{{ errors.first('email') }}
                                </span>
                            </div>

                            <div class="form-group" :class="[errors.has('password') ? 'has-error' : '']">
                                <label for="password" class="mandatory label-style text-uppercase">
                                    {{ __('shop::app.customer.login-form.password') }}
                                </label>

                                <input
                                    type="password"
                                    class="form-style w-100"
                                    name="password"
                                    v-validate="'required'"
                                    value="{{ old('password') }}"
                                    data-vv-as="&quot;{{ __('shop::app.customer.login-form.password') }}&quot;" />

                                <span class="control-error" v-if="errors.has('password')">
                                    @{{ errors.first('password') }}
                                </span>

                                <div class="mt10">
                                    @if (Cookie::has('enable-resend'))
                                        @if (Cookie::get('enable-resend') == true)
                                            <a href="{{ route('customer.resend.verification-email', Cookie::get('email-for-resend')) }}">{{ __('shop::app.customer.login-form.resend-verification') }}</a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}

                            <div class="text-center">
                                <div class="mb-2">
                                    <button class="btn text-uppercase" type="submit">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <a href="{{ route('customer.forgot-password.create') }}" class="accent-link">
                                    {{ __('Forgotten your password?') }}
                                </a>
                            </div>
                        </form>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}
                    
                    <div class="bottom-section pt-5 mt-5 text-center">
                        <h2 class="t-l text-uppercase mb-4">
                            {{ __('New Customer?')}}
                        </h2>

                        <a href="{{ route('customer.register.index') }}" class="btn-new-customer">
                            <button type="button" class="btn btn-outline text-uppercase">
                                {{ __('Register here')}}
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        {!! view_render_event('bagisto.shop.customers.login.after') !!}
    </div>
@endsection
