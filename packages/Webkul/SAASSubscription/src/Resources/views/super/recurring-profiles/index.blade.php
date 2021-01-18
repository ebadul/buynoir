@extends('saas::super.layouts.content')

@section('page_title')
    {{ __('saassubscription::app.super-user.recurring-profiles.title') }}
@stop

@section('content')
    <div class="content mt-50">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('saassubscription::app.super-user.recurring-profiles.title') }}</h1>
            </div>
        </div>

        <div class="page-content">

            {!! app('Webkul\SAASSubscription\DataGrids\RecurringProfilesDataGrid')->render() !!}

        </div>
    </div>
@stop