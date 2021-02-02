@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.signup-form.page-title') }}
@endsection

@section('content-wrapper')
    <div class="auth-content form-container">
        <div class="container">
            <div class="register">
                <div class="body">
                    <h3 class="text-center text-uppercase t-l">
                        {{ __('Welcome')}}
                    </h3>

                    <p class="text-center text-uppercase my-5">
                        {{ __('Register with your email')}}
                    </p>

                    {!! view_render_event('bagisto.shop.customers.signup.before') !!}

                    <form
                        method="post"
                        action="{{ route('customer.register.create') }}"
                        @submit.prevent="onSubmit">

                        {{ csrf_field() }}

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.lastname.after') !!}

                        <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                            <label for="email" class="required label-style text-uppercase">
                                {{ __('shop::app.customer.signup-form.email') }}
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                v-validate="'required|email'"
                                value="{{ old('email') }}"
                                data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;" />

                            <span class="control-error" v-if="errors.has('email')">
                                @{{ errors.first('email') }}
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.email.after') !!}
                        
                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                        <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                            <label for="first_name" class="required label-style text-uppercase">
                                {{ __('shop::app.customer.signup-form.firstname') }}
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="first_name"
                                v-validate="'required'"
                                value="{{ old('first_name') }}"
                                data-vv-as="&quot;{{ __('shop::app.customer.signup-form.firstname') }}&quot;" />

                            <span class="control-error" v-if="errors.has('first_name')">
                                @{{ errors.first('first_name') }}
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.firstname.after') !!}

                        <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                            <label for="last_name" class="required label-style text-uppercase">
                                {{ __('shop::app.customer.signup-form.lastname') }}
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="last_name"
                                v-validate="'required'"
                                value="{{ old('last_name') }}"
                                data-vv-as="&quot;{{ __('shop::app.customer.signup-form.lastname') }}&quot;" />

                            <span class="control-error" v-if="errors.has('last_name')">
                                @{{ errors.first('last_name') }}
                            </span>
                        </div>

                        <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                            <label for="password" class="required label-style text-uppercase">
                                {{ __('shop::app.customer.signup-form.password') }}
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                v-validate="'required|min:6'"
                                ref="password"
                                value="{{ old('password') }}"
                                data-vv-as="&quot;{{ __('shop::app.customer.signup-form.password') }}&quot;" />

                            <span class="control-error" v-if="errors.has('password')">
                                @{{ errors.first('password') }}
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.password.after') !!}

                        <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                            <label for="password_confirmation" class="required label-style text-uppercase">
                                {{ __('shop::app.customer.signup-form.confirm_pass') }}
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="password_confirmation"
                                v-validate="'required|min:6|confirmed:password'"
                                data-vv-as="&quot;{{ __('shop::app.customer.signup-form.confirm_pass') }}&quot;" />

                            <span class="control-error" v-if="errors.has('password_confirmation')">
                                @{{ errors.first('password_confirmation') }}
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}

                        <div class="text-center mt-3">
                            <button class="btn text-uppercase" type="submit">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>

                    {!! view_render_event('bagisto.shop.customers.signup.after') !!}
                </div>
                <div class="bottom-section pt-5 mt-5 text-center">
                    <h2 class="t-l text-uppercase mb-4">
                        {{ __('Already registered?')}}
                    </h2>

                    <a href="{{ route('customer.session.index') }}" class="btn-new-customer">
                        <button type="button" class="btn btn-outline">
                            {{ __('Login here')}}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
