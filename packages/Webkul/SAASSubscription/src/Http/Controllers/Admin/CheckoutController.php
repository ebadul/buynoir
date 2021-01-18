<?php

namespace Webkul\SAASSubscription\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Repositories\PlanRepository;

class CheckoutController extends Controller
{
    /**
     * PlanRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\PlanRepository
     */
    protected $planRepository;

    /**
     * Paypal object
     *
     * @var \Webkul\SAASSubscription\Helpers\Paypal
     */
    protected $paypalHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASSubscription\Repositories\PlanRepository  $planRepository
     * @return void
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;

        $this->_config = request('_config');
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
     * Proceed to purchase selected plan
     *
     * @return \Illuminate\Http\Response
     */
    public function purchase()
    {
        $data = request()->all();

        $plan = $this->planRepository->findOrFail(request('plan'));

        $data = array_merge($data, [
            'plan'             => $plan,
            'type'             => 'paypal',
            'cycle_expired_on' => Carbon::now(),
            'amount'           => $data['period_unit'] == 'month'
                                  ? $plan->monthly_amount
                                  : $plan->yearly_amount * 12,
        ]);

        session()->put('subscription_cart', $data);

        return redirect()->route('admin.subscription.paypal.start');
    }
}