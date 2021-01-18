@extends('saas::super.layouts.content')

@section('page_title')
    {{ __('saassubscription::app.super-user.plans.title') }}
@stop

@section('content')
    <div class="content mt-50">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('saassubscription::app.super-user.plans.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('super.subscription.plan.create') }}" class="btn btn-lg btn-primary">
                    {{ __('saassubscription::app.super-user.plans.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('companies', 'Webkul\SAASSubscription\DataGrids\PlanDataGrid')
            {!! $companies->render() !!}
        </div>
    </div>
@stop