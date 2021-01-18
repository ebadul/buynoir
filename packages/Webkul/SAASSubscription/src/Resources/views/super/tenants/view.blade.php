@extends('saas::super.layouts.content')

@section('page_title')
    {{ __('saas::app.super-user.tenants.view-title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/super/companies/tenants') }}';"></i>

                    {{ __('saas::app.super-user.tenants.view-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button class="btn btn-lg btn-primary" @click="showModal('activateManualPlan')">
                    {{ __('saassubscription::app.super-user.plans.assign-plan') }}
                </button>

                <?php $recurringProfile = app('Webkul\SAASSubscription\Helpers\Subscription')->getCurrentRecurringProfile($company[0]); ?>

                @if ($recurringProfile && $recurringProfile->state != 'Cancelled' && ! in_array($recurringProfile->type, ['trial', 'free', 'manual']))
                    <a href="{{ route('super.subscription.plan.cancel', $recurringProfile->id) }}" class="btn btn-lg btn-black" v-alert:message="'{{ __('saassubscription::app.super-user.plans.cancel-confirm-msg') }}'">
                            {{ __('saassubscription::app.super-user.plans.cancel-plan') }}
                        </a>
                @endif
            </div>
        </div>

        <div class="page-content">
            <div class="table">
                <table>
                    <thead>
                        <tr style="font-weight: bold">
                            <td>{{ __('saas::app.super-user.tenants.no-of-products') }}</td>
                            <td>{{ __('saas::app.super-user.tenants.no-of-attributes') }}</td>
                            <td>{{ __('saas::app.super-user.tenants.no-of-customers') }}</td>
                            <td>{{ __('saas::app.super-user.tenants.no-of-customer-groups') }}</td>
                            <td>{{ __('saas::app.super-user.tenants.no-of-categories') }}</td>
                            <td>{{ __('saas::app.super-user.tenants.mapped-domain') }}</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ $company[1]['products'] }}</td>
                            <td>{{ $company[1]['attributes'] }}</td>
                            <td>{{ $company[1]['customers'] }}</td>
                            <td>{{ $company[1]['customer-groups'] }}</td>
                            <td>{{ $company[1]['categories'] }}</td>
                            <td>{{ $company[0]->domain }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <modal id="activateManualPlan" :is-open="modalIds.activateManualPlan">
        <h3 slot="header">{{ __('saassubscription::app.super-user.plans.assign-plan') }}</h3>

        <div slot="body">
            <form action="{{ route('super.subscription.plan.assign', $company[0]->id) }}" method="post">

                <div class="container">
                    @csrf()

                    <div class="control-group">
                        <label for="plan">{{ __('saassubscription::app.super-user.plans.plan') }}</label>
                        <select class="control" id="plan" name="plan">
                            @foreach (app('Webkul\SAASSubscription\Repositories\PlanRepository')->where('status', 1)->get() as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="control-group">
                        <label for="period_unit">{{ __('saassubscription::app.super-user.plans.period-unit') }}</label>
                        <select class="control" id="period_unit" name="period_unit">
                            <option value="month">{{ __('saassubscription::app.super-user.plans.month') }}</option>
                            <option value="year">{{ __('saassubscription::app.super-user.plans.year') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('saassubscription::app.super-user.plans.assign') }}
                    </button>
                </div>

            </form>
        </div>
    </modal>
@stop