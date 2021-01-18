@inject('subscriptionHelper', 'Webkul\SAASSubscription\Helpers\Subscription')

@if ($subscriptionHelper->isServiceStopped())

    @if (! in_array(request()->route()->getName(), [
        'admin.subscription.plan.overview',
        'admin.subscription.plan.index',
        'admin.subscription.checkout.index',
        'admin.subscription.invoice.index',
        'admin.subscription.invoice.view'
    ]))

        <service-stopped-model></service-stopped-model>

        @push('scripts')

            <?php $recurringProfile = $subscriptionHelper->getCurrentRecurringProfile() ?>

            <script type="text/x-template" id="service-stopped-model-template">
                <div>
                    <modal id="isServiceStoped" :is-open="this.$root.modalIds.isServiceStoped">
                        @if (! $recurringProfile)
                            <h3 slot="header">{{ __('saassubscription::app.admin.layouts.purchase-plan-heading') }}</h3>

                            <div slot="body">
                                <p>
                                    {{ __('saassubscription::app.admin.layouts.purchase-plan-notification') }}
                                </p>
                                
                                @if (true)
                                    <a href="{{ route('admin.subscription.plan.index') }}" class="btn btn-lg btn-primary">
                                        {{ __('saassubscription::app.admin.layouts.choose-plan') }}
                                    </a>
                                @endif
                            </div>
                        @elseif ($recurringProfile->type == 'trial')
                            <h3 slot="header">{{ __('saassubscription::app.admin.layouts.trial-expired-heading') }}</h3>

                            <div slot="body">
                                <p>
                                    {{ __('saassubscription::app.admin.layouts.trial-expired-notification', ['date' => $recurringProfile->cycle_expired_on]) }}
                                </p>
                                
                                @if (true)
                                    <a href="{{ route('admin.subscription.plan.index') }}" class="btn btn-lg btn-primary">
                                        {{ __('saassubscription::app.admin.layouts.choose-plan') }}
                                    </a>
                                @endif
                            </div>
                        @elseif ($recurringProfile->state == "Cancelled")
                            <h3 slot="header">{{ __('saassubscription::app.admin.layouts.subscription-stopped-heading') }}</h3>

                            <div slot="body">
                                <p>
                                    {{ __('saassubscription::app.admin.layouts.subscription-stopped-notification', ['date' => $recurringProfile->cycle_expired_on]) }}
                                </p>

                                @if (true)
                                    <a href="{{ route('admin.subscription.plan.index') }}" class="btn btn-lg btn-primary">
                                        {{ __('saassubscription::app.admin.layouts.choose-plan') }}
                                    </a>
                                @endif
                            </div>
                        @elseif ($recurringProfile->state == "Suspending")
                            <h3 slot="header">{{ __('saassubscription::app.admin.layouts.subscription-suspended-heading') }}</h3>

                            <div slot="body">
                                <p>
                                    {{ __('saassubscription::app.admin.layouts.subscription-suspended-notification') }}
                                </p>

                                @if (true)
                                    <a href="{{ route('admin.subscription.plan.index') }}" class="btn btn-lg btn-primary">
                                        {{ __('saassubscription::app.admin.layouts.choose-plan') }}
                                    </a>
                                @endif
                            </div>
                        @else
                            <h3 slot="header">{{ __('saassubscription::app.admin.layouts.payment-due-heading') }}</h3>

                            <div slot="body">
                                <p>
                                    {{ __('saassubscription::app.admin.layouts.payment-due-notification') }}
                                </p>

                                @if (true)
                                    <a href="{{ route('admin.subscription.plan.index') }}" class="btn btn-lg btn-primary">
                                        {{ __('saassubscription::app.admin.layouts.choose-plan') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </modal>
                </div>
            </script>

            <script>
                Vue.component('service-stopped-model', {

                    template: '#service-stopped-model-template',

                    mounted: function() {
                        this.$root.showModal('isServiceStoped')
                    }
                });
            </script>
        @endpush
    @endif
@endif