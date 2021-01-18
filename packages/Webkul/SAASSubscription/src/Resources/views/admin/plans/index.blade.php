@extends('admin::layouts.master')

@section('css')
    @include ('saassubscription::admin.layouts.style')
@stop

@section('page_title')
    {{ __('saassubscription::app.admin.plans.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('saassubscription::app.admin.plans.title') }}
                </h1>
            </div>
        </div>

        <div class="page-content dashboard">

            @include('saassubscription::admin.layouts.tabs')

            <div class="plan-list">
                @foreach ($plans as $plan)
                    <div class="card">
                        <div class="card-title">
                            {{ $plan->name }}
                        </div>

                        <div class="card-info">
                            <form action="{{ route('admin.subscription.plan.add-to-cart', $plan->id) }}" method="post">
                                @csrf()

                                <h2>{{ core()->formatPrice($plan->yearly_amount, config('app.currency')) }}</h2>

                                <p>{!! __('saassubscription::app.admin.plans.plan-description', ['amount' => '<b>' . core()->formatPrice($plan->monthly_amount, config('app.currency')) . '</b>']) !!}</p>
                                
                                <ul>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-products', ['count' => '<b>' . $plan->allowed_products . '</b>']) !!}</li>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-categories', ['count' => '<b>' . $plan->allowed_categories . '</b>']) !!}</li>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-attributes', ['count' => '<b>' . $plan->allowed_attributes . '</b>']) !!}</li>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-attribute-families', ['count' => '<b>' . $plan->allowed_attribute_families . '</b>']) !!}</li>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-channels', ['count' => '<b>' . $plan->allowed_channels . '</b>']) !!}</li>
                                    <li>{!! __('saassubscription::app.admin.plans.allowed-orders', ['count' => '<b>' . $plan->allowed_orders . '</b>']) !!}</li>
                                </ul>

                                <button class="btn btn-lg btn-primary">
                                    {{ __('saassubscription::app.admin.plans.purchase') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>
@stop