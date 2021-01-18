@extends('saas::super.layouts.content')

@section('page_title')
    {{ __('saassubscription::app.super-user.plans.edit-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('super.subscription.plan.update', $plan->id) }}">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/super/companies') }}';"></i>

                        {{ __('saassubscription::app.super-user.plans.edit-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('saassubscription::app.super-user.plans.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="container">
                    @csrf()

                    {!! view_render_event('bagisto.super.subscription.plan.create.before') !!}

                    <accordian :title="'{{ __('saassubscription::app.super-user.plans.general') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                                <label for="code" class="required">{{ __('saassubscription::app.super-user.plans.code') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="code" name="code" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.code') }}&quot;" value="{{ old('code') ?: $plan->code }}" />
                                <span class="control-error" v-if="errors.has('code')">@{{ errors.first('code') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('saassubscription::app.super-user.plans.name') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.name') }}&quot;" value="{{ old('name') ?: $plan->name }}" />
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="description">{{ __('saassubscription::app.super-user.plans.description') }}</label>
                                <textarea class="control" id="description" name="description">{{ old('description') ?: $plan->description }}</textarea>
                            </div>

                        </div>
                    </accordian>

                    <accordian :title="'{{ __('saassubscription::app.super-user.plans.billing-amount') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('monthly_amount') ? 'has-error' : '']">
                                <label for="monthly_amount" class="required">{{ __('saassubscription::app.super-user.plans.monthly-amount') }}</label>
                                <input type="text" v-validate="'required|min_value:0'" class="control" id="monthly_amount" name="monthly_amount" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.monthly-amount') }}&quot;" value="{{ old('monthly_amount') ?: $plan->monthly_amount }}" />
                                <span class="control-error" v-if="errors.has('monthly_amount')">@{{ errors.first('monthly_amount') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('yearly_amount') ? 'has-error' : '']">
                                <label for="yearly_amount" class="required">{{ __('saassubscription::app.super-user.plans.yearly-amount') }}</label>
                                <input type="text" v-validate="'required|min_value:0'" class="control" id="yearly_amount" name="yearly_amount" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.yearly-amount') }}&quot;" value="{{ old('yearly_amount') ?: $plan->yearly_amount }}" />
                                <span class="control-error" v-if="errors.has('yearly_amount')">@{{ errors.first('yearly_amount') }}</span>
                            </div>

                        </div>
                    </accordian>

                    <accordian :title="'{{ __('saassubscription::app.super-user.plans.plan-limitation') }}'" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('allowed_products') ? 'has-error' : '']">
                                <label for="allowed_products" class="required">{{ __('saassubscription::app.super-user.plans.allowed-products') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_products" name="allowed_products" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-products') }}&quot;" value="{{ old('allowed_products') ?: $plan->allowed_products }}" />
                                <span class="control-error" v-if="errors.has('allowed_products')">@{{ errors.first('allowed_products') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('allowed_categories') ? 'has-error' : '']">
                                <label for="allowed_categories" class="required">{{ __('saassubscription::app.super-user.plans.allowed-categories') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_categories" name="allowed_categories" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-categories') }}&quot;" value="{{ old('allowed_categories') ?: $plan->allowed_categories }}" />
                                <span class="control-error" v-if="errors.has('allowed_categories')">@{{ errors.first('allowed_categories') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('allowed_attributes') ? 'has-error' : '']">
                                <label for="allowed_attributes" class="required">{{ __('saassubscription::app.super-user.plans.allowed-attributes') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_attributes" name="allowed_attributes" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-attributes') }}&quot;" value="{{ old('allowed_attributes') ?: $plan->allowed_attributes }}" />
                                <span class="control-error" v-if="errors.has('allowed_attributes')">@{{ errors.first('allowed_attributes') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('allowed_attribute_families') ? 'has-error' : '']">
                                <label for="allowed_attribute_families" class="required">{{ __('saassubscription::app.super-user.plans.allowed-attribute-families') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_attribute_families" name="allowed_attribute_families" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-attribute-families') }}&quot;" value="{{ old('allowed_attribute_families') ?: $plan->allowed_attribute_families }}" />
                                <span class="control-error" v-if="errors.has('allowed_attribute_families')">@{{ errors.first('allowed_attribute_families') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('allowed_channels') ? 'has-error' : '']">
                                <label for="allowed_channels" class="required">{{ __('saassubscription::app.super-user.plans.allowed-channels') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_channels" name="allowed_channels" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-channels') }}&quot;" value="{{ old('channels') ?: $plan->allowed_channels }}" />
                                <span class="control-error" v-if="errors.has('allowed_channels')">@{{ errors.first('allowed_channels') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('allowed_orders') ? 'has-error' : '']">
                                <label for="allowed_orders" class="required">{{ __('saassubscription::app.super-user.plans.allowed-orders') }}</label>
                                <input type="text" v-validate="'required|numeric|min:1'" class="control" id="allowed_orders" name="allowed_orders" data-vv-as="&quot;{{ __('saassubscription::app.super-user.plans.allowed-orders') }}&quot;" value="{{ old('allowed_orders') ?: $plan->allowed_orders }}" />
                                <span class="control-error" v-if="errors.has('allowed_orders')">@{{ errors.first('allowed_orders') }}</span>
                            </div>

                        </div>
                    </accordian>

                    {!! view_render_event('bagisto.super.subscription.plan.create.after') !!}

                </div>
            </div>
        </form>
    </div>
@stop