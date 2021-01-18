@extends('admin::layouts.master')

@section('css')
    @include ('saassubscription::admin.layouts.style')
@stop

@section('page_title')
    {{ __('saassubscription::app.admin.checkout.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('saassubscription::app.admin.checkout.title') }}
                </h1>
            </div>
        </div>

        <div class="page-content">

            @include('saassubscription::admin.layouts.tabs')
            
            <form action="{{ route('admin.subscription.checkout.purchase') }}" method="post">
                
                @csrf()

                <checkout-component></checkout-component>

            </form>
        </div>

    </div>
@stop

@push('scripts')
    <script type="text/x-template" id="checkout-template">
        <div class="checkout">
            <div class="sale-container">
                <div class="sale-section">
                    <div class="secton-title">
                        <span>{{ __('saassubscription::app.admin.checkout.payment-information') }}</span>
                    </div>
                    
                    <div class="section-content">

                        <div class="control-group">
                            <label for="plan">{{ __('saassubscription::app.admin.checkout.plan') }}</label>
                            <select class="control" id="plan" name="plan" v-model="plan">
                                <option v-for="plan in plans[period_unit]" :value="plan.id">@{{ plan.label }}</option>
                            </select>
                        </div>

                        <div class="control-group">
                            <label for="period_unit">{{ __('saassubscription::app.admin.checkout.billing-cycle') }}</label>
                            <select class="control" id="period_unit" name="period_unit" v-model="period_unit">
                                <option value="month">{{ __('saassubscription::app.admin.checkout.month') }}</option>
                                <option value="year">{{ __('saassubscription::app.admin.checkout.year') }}</option>
                            </select>
                        </div>

                        <div class="control-group">
                            <label for="tin">{{ __('saassubscription::app.admin.checkout.tin') }}</label>
                            <input type="text" class="control" id="tin" name="tin"/>
                        </div>

                    </div>
                </div>

                <div class="sale-section">
                    <div class="secton-title">
                        <span>{{ __('saassubscription::app.admin.checkout.billing-address') }}</span>
                    </div>
                    
                    <div class="section-content">

                        <div class="control-group" :class="[errors.has('address[first_name]') ? 'has-error' : '']">
                            <label for="address[first_name]" class="required">{{ __('saassubscription::app.admin.checkout.first-name') }}</label>
                            <input v-validate="'required'" class="control" id="address[first_name]" name="address[first_name]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.first-name') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[first_name]')">@{{ errors.first('address[first_name]') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[last_name]') ? 'has-error' : '']">
                            <label for="address[last_name]" class="required">{{ __('saassubscription::app.admin.checkout.last-name') }}</label>
                            <input v-validate="'required'" class="control" id="address[last_name]" name="address[last_name]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.last-name') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[last_name]')">@{{ errors.first('address[last_name]') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[email]') ? 'has-error' : '']">
                            <label for="address[email]" class="required">{{ __('saassubscription::app.admin.checkout.email') }}</label>
                            <input v-validate="'required'" class="control" id="address[email]" name="address[email]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.email') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[email]')">@{{ errors.first('address[email]') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[address1]') ? 'has-error' : '']">
                            <label for="address[address1]" class="required">{{ __('saassubscription::app.admin.checkout.address1') }}</label>
                            <input v-validate="'required'" class="control" id="address[address1]" name="address[address1]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.address1') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[address1]')">@{{ errors.first('address[address1]') }}</span>
                        </div>

                        <div class="control-group">
                            <label for="address[address2]">{{ __('saassubscription::app.admin.checkout.address2') }}</label>
                            <input class="control" id="address[address2]" name="address[address2]"/>
                        </div>

                        <div class="control-group" :class="[errors.has('address[city]') ? 'has-error' : '']">
                            <label for="address[city]" class="required">{{ __('saassubscription::app.admin.checkout.city') }}</label>
                            <input v-validate="'required'" class="control" id="address[city]" name="address[city]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.city') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[city]')">@{{ errors.first('address[city]') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[postcode]') ? 'has-error' : '']">
                            <label for="address[postcode]" class="required">{{ __('saassubscription::app.admin.checkout.postcode') }}</label>
                            <input v-validate="'required'" class="control" id="address[postcode]" name="address[postcode]" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.postcode') }}&quot;"/>
                            <span class="control-error" v-if="errors.has('address[postcode]')">@{{ errors.first('address[postcode]') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[country]') ? 'has-error' : '']">
                            <label for="address[country]" class="required">
                                {{ __('saassubscription::app.admin.checkout.country') }}
                            </label>

                            <select type="text" v-validate="'required'" class="control" id="address[country]" name="address[country]" v-model="country" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.country') }}&quot;">
                                <option value=""></option>

                                @foreach (core()->countries() as $country)

                                    <option value="{{ $country->code }}">{{ $country->name }}</option>

                                @endforeach
                            </select>

                            <span class="control-error" v-if="errors.has('address[country]')">
                                @{{ errors.first('address[country]') }}
                            </span>
                        </div>

                        <div class="control-group" :class="[errors.has('address[state]') ? 'has-error' : '']">
                            <label for="address[state]" class="required">
                                {{ __('saassubscription::app.admin.checkout.state') }}
                            </label>

                            <input type="text" v-validate="'required'" class="control" id="state" name="address[state]" v-model="state" v-if="!haveStates()" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.state') }}&quot;"/>

                            <select v-validate="'required'" class="control" id="address[state]" name="address[state]" v-model="state" v-if="haveStates()" data-vv-as="&quot;{{ __('saassubscription::app.admin.checkout.state') }}&quot;">

                                <option value="">{{ __('saassubscription::app.admin.checkout.select-state') }}</option>

                                <option v-for='(state, index) in countryStates[country]' :value="state.code">
                                    @{{ state.default_name }}
                                </option>

                            </select>

                            <span class="control-error" v-if="errors.has('address[state]')">
                                @{{ errors.first('address[state]') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sale-summary">
                <h3>{{ __('saassubscription::app.admin.checkout.summary') }}</h3>
                <div class="item-detail">
                    <label>
                        {{ __('saassubscription::app.admin.checkout.billing-cycle') }}
                    </label>
                    
                    <label class="right">
                        <span v-if="period_unit == 'month'">
                            {{ __('saassubscription::app.admin.checkout.month') }}
                        </span>

                        <span v-else>
                            {{ __('saassubscription::app.admin.checkout.annual') }}
                        </span>
                    </label>
                </div>
                
                <div class="item-detail">
                    <label id="taxrate-0">{{ __('saassubscription::app.admin.checkout.plan') }}</label>
                    <label id="basetaxamount-0" class="right">
                        @{{ plans[period_unit][plan]['name'] }}
                    </label>
                </div>
                
                <div id="grand-total-detail" class="payable-amount">
                    <label>{{ __('saassubscription::app.admin.checkout.subtotal') }}</label>
                    <label id="grand-total-amount-detail" class="right">
                        @{{ plans[period_unit][plan]['total'] }}
                    </label>
                </div>

                <button class="btn btn-lg btn-primary">
                    {{ __('saassubscription::app.admin.plans.purchase') }}
                </button>
            </div>
        </div>
    </script>

    <script>

        Vue.component('checkout-component', {

            template: '#checkout-template',

            inject: ['$validator'],

            data: function() {
                return {
                    plan: {{ session()->get('subscription_cart.plan.id') }},

                    plans: @json(app('Webkul\SAASSubscription\Helpers\Subscription')->getFormatedPlans()),

                    period_unit: 'month',

                    country: '',

                    state: '',

                    countryStates: @json(core()->groupedStatesByCountries())
                }
            },

            methods: {
                haveStates: function () {
                    if (this.countryStates[this.country] && this.countryStates[this.country].length)
                        return true;

                    return false;
                },
            }
        });

    </script>
@endpush
