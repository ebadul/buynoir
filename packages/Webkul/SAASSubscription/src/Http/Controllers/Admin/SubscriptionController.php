<?php

namespace Webkul\SAASSubscription\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Repositories\PlanRepository;
use Webkul\SAASSubscription\Helpers\Subscription;

class SubscriptionController extends Controller
{
    /**
     * PlanRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\PlanRepository
     */
    protected $planRepository;

    /**
     * Subscription object
     *
     * @var \Webkul\SAASSubscription\Helpers\Subscription
     */
    protected $subscriptionHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASSubscription\Repositories\PlanRepository  $planRepository
     * @param  \Webkul\SAASSubscription\Helpers\Subscription  $subscriptionHelper
     * @return void
     */
    public function __construct(
        PlanRepository $planRepository,
        Subscription $subscriptionHelper
    )
    {
        $this->planRepository = $planRepository;

        $this->subscriptionHelper = $subscriptionHelper;

        $this->_config = request('_config');
    }

    /**
     * Show the view for the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $recurringProfile = $this->subscriptionHelper->getCurrentRecurringProfile();

        if (! $recurringProfile) {
            return redirect()->route('admin.subscription.plan.index');
        }

        return view($this->_config['view'], compact('recurringProfile'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $plans = $this->planRepository->all();

        return view($this->_config['view'], compact('plans'));
    }

    /**
     * Function for guests user to add the product in the cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addToCart($id)
    {
        $plan = $this->planRepository->findOrFail($id);

        $errors = $this->subscriptionHelper->validateChangePlan($plan);

        if (count($errors)) {
            session()->flash('warning', implode(' ', $errors));

            return redirect()->back();
        }

        session()->put('subscription_cart', [
            'plan'        => $plan,
            'period_unit' => 'month',
        ]);

        if (! (float) $plan->monthly_amount) {
            $this->subscriptionHelper->activateFreePlan();

            session()->flash('success', trans('saassubscription::app.admin.plans.free-plan-activated'));

            return redirect()->route('admin.subscription.plan.overview');
        }

        return redirect()->route($this->_config['redirect']);
    }
}