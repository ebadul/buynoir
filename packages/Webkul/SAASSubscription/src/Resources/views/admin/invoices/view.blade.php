@extends('admin::layouts.master')

@section('css')
    @include ('saassubscription::admin.layouts.style')
@stop

@section('page_title')
    {{ __('saassubscription::app.admin.invoices.view-title', ['invoice_id' => $invoice->id]) }}
@stop

@section('content-wrapper')
    <div class="content full-page">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('saassubscription::app.admin.invoices.view-title', ['invoice_id' => $invoice->id]) }}
                </h1>
            </div>
        </div>

        <div class="page-content">

            @include('saassubscription::admin.layouts.tabs')

            <div class="sale-container">

                <accordian :title="'{{ __('saassubscription::app.admin.invoices.invoice-and-account') }}'" :active="true">
                    <div slot="body">

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('saassubscription::app.admin.invoices.invoice-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('saassubscription::app.admin.invoices.invoice-id') }}
                                    </span>

                                    <span class="value">
                                        #{{ $invoice->id }}
                                    </span>
                                </div>

                                @if ($invoice->recurring_profile->reference_id != '')
                                    <div class="row">
                                        <span class="title">
                                            {{ __('saassubscription::app.admin.invoices.profile-id') }}
                                        </span>

                                        <span class="value">
                                            {{ $invoice->recurring_profile->reference_id }}
                                        </span>
                                    </div>
                                @endif

                                <div class="row">
                                    <span class="title">
                                        {{ __('saassubscription::app.admin.invoices.invoice-date') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->created_at }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('saassubscription::app.admin.invoices.invoice-status') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="sale-section">
                            <div class="secton-title">
                                <span>{{ __('saassubscription::app.admin.invoices.account-info') }}</span>
                            </div>

                            <div class="section-content">
                                <div class="row">
                                    <span class="title">
                                        {{ __('saassubscription::app.admin.invoices.customer-name') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->customer_name }}
                                    </span>
                                </div>

                                <div class="row">
                                    <span class="title">
                                        {{ __('saassubscription::app.admin.invoices.customer-email') }}
                                    </span>

                                    <span class="value">
                                        {{ $invoice->customer_email }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </accordian>

                <accordian :title="'{{ __('saassubscription::app.admin.invoices.plan-info') }}'" :active="true">
                    <div slot="body">

                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ __('saassubscription::app.admin.invoices.sku') }}</th>
                                        <th>{{ __('saassubscription::app.admin.invoices.plan') }}</th>
                                        <th>{{ __('saassubscription::app.admin.invoices.expiration-date') }}</th>
                                        <th>{{ __('saassubscription::app.admin.invoices.subtotal') }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td>
                                            {{ $invoice->purchased_plan->code }}
                                        </td>

                                        <td>
                                            @if ($invoice->recurring_profile->type == 'trial')
                                                {{ __('saassubscription::app.admin.invoices.plan-name', ['plan' => $invoice->purchased_plan->name]) }}
                                            @else
                                                {{ $invoice->purchased_plan->name }}
                                            @endif
                                        </td>

                                        <td>{{ $invoice->cycle_expired_on }}</td>

                                        <td>{{ core()->formatPrice($invoice->grand_total, config('app.currency')) }}</td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>

                        <table class="sale-summary">
                            <tr>
                                <td>{{ __('saassubscription::app.admin.invoices.subtotal') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->grand_total, config('app.currency')) }}</td>
                            </tr>

                            <tr class="bold">
                                <td>{{ __('saassubscription::app.admin.invoices.grand-total') }}</td>
                                <td>-</td>
                                <td>{{ core()->formatPrice($invoice->grand_total, config('app.currency')) }}</td>
                            </tr>
                        </table>
                    </div>
                </accordian>


            </div>

        </div>

    </div>
@stop