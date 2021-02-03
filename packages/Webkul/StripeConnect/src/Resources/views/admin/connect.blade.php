@extends('admin::layouts.content')

@section('page_title')
    {{ __('stripe_saas::app.admin.stripe.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('stripe_saas::app.admin.stripe.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @if ( $client_id )
                @if (! isset($stripeConnect->id) )
                    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{  $client_id }}&stripe_landing=register&scope=read_write&redirect_uri={{ route('admin.stripe.retrieve-grant') }}" class="btn btn-lg btn-primary">{{ __('stripe_saas::app.admin.stripe.connect-stripe') }}</a>
                @else
                    <a href="{{ route('admin.stripe.revoke-access') }}" class="btn btn-lg btn-primary">{{ __('stripe_saas::app.admin.stripe.revoke-access') }}</a>
                @endif
            @else
                <span class="warning" style="font-size: 18px; font-weight: bold; color: #ff5656">
                    {{ __('stripe_saas::app.admin.stripe.client-id-missing') }}
                    <br/><br/>
                </span>
            @endif
        </div>
    </div>
@stop