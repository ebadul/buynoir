<div class="tabs">

    <ul>
        <li @if (request()->route()->getName() == 'admin.subscription.plan.overview') class="active" @endif>
            <a href="{{ route('admin.subscription.plan.overview') }}">
                {{ __('saassubscription::app.admin.layouts.overview') }}
            </a>
        </li>

        <li @if (in_array(request()->route()->getName(), ['admin.subscription.plan.index', 'admin.subscription.checkout.index'])) class="active" @endif>
            <a href="{{ route('admin.subscription.plan.index') }}">
                {{ __('saassubscription::app.admin.layouts.plans') }}
            </a>
        </li>

        <li @if (in_array(request()->route()->getName(), ['admin.subscription.invoice.index', 'admin.subscription.invoice.view'])) class="active" @endif>
            <a href="{{ route('admin.subscription.invoice.index') }}">
                {{ __('saassubscription::app.admin.layouts.invoices') }}
            </a>
        </li>
    </ul>

</div>