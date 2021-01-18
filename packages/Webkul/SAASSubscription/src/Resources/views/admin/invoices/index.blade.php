@extends('admin::layouts.master')

@section('css')
    @include ('saassubscription::admin.layouts.style')
@stop

@section('page_title')
    {{ __('saassubscription::app.admin.invoices.title') }}
@stop

@section('content-wrapper')
    <div class="content full-page">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('saassubscription::app.admin.invoices.title') }}
                </h1>
            </div>
        </div>

        <div class="page-content dashboard">

            @include('saassubscription::admin.layouts.tabs')

            <div class="table" style="padding: 20px 0">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('saassubscription::app.admin.invoices.id') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.plan') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.customer-name') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.total') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.status') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.date') }}</th>
                            <th>{{ __('saassubscription::app.admin.invoices.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->id }}</td>
                                <td>{{ $invoice->purchased_plan->name }}</td>
                                <td>{{ $invoice->customer_name }}</td>
                                <td>{{ core()->formatPrice($invoice->grand_total, config('app.currency')) }}</td>
                                <td>{{ $invoice->status }}</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td class="action">
                                    <a href="{{ route('admin.subscription.invoice.view', $invoice->id) }}">
                                        <i class="icon eye-icon"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if (! $invoices->count())
                            <tr>
                                <td class="empty" colspan="7">{{ __('admin::app.common.no-result-found') }}</td>
                            <tr>
                        @endif
                </table>
            </div>

        </div>

    </div>
@stop