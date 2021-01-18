<?php

namespace Webkul\SAASSubscription\Http\Controllers\Super;

use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASCustomizer\Repositories\Super\CompanyRepository;
use Webkul\SAASSubscription\Repositories\RecurringProfileRepository;
use Webkul\SAASSubscription\Repositories\PlanRepository;
use Webkul\SAASSubscription\Helpers\Subscription;
use Webkul\SAASSubscription\Helpers\Paypal;
use Webkul\SAASCustomizer\Facades\Company;

class RecurringProfileController extends Controller
{
    /**
     * CompanyRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\CompanyRepository
     */
    protected $companyRepository;

    /**
     * RecurringProfileRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\RecurringProfileRepository
     */
    protected $recurringProfileRepository;
    
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
     * Paypal object
     *
     * @var \Webkul\SAASSubscription\Helpers\Paypal
     */
    protected $paypalHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASCustomizer\Repositories\Super\CompanyRepository  $companyRepository
     * @param  \Webkul\SAASSubscription\Repositories\RecurringProfileRepository  $recurringProfileRepository
     * @param  \Webkul\SAASSubscription\Repositories\PlanRepository  $planRepository
     * @param  \Webkul\SAASSubscription\Helpers\Subscription  $subscriptionHelper
     * @param  \Webkul\SAASSubscription\Helpers\Paypal  $paypalHelper
     * @return void
     */
    public function __construct(
        CompanyRepository $companyRepository,
        RecurringProfileRepository $recurringProfileRepository,
        PlanRepository $planRepository,
        Subscription $subscriptionHelper,
        Paypal $paypalHelper
    )
    {
        $this->companyRepository = $companyRepository;

        $this->recurringProfileRepository = $recurringProfileRepository;

        $this->planRepository = $planRepository;

        $this->subscriptionHelper = $subscriptionHelper;

        $this->paypalHelper = $paypalHelper;

        $this->_config = request('_config');

        $this->middleware('auth:super-admin');

        if (! Company::isAllowed()) {
            throw new \Exception('not_allowed_to_visit_this_section', 400);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $recurringProfile = $this->recurringProfileRepository->findOrFail($id);

        return view($this->_config['view'], compact('recurringProfile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign($id)
    {
        $plan = $this->planRepository->findOrFail(request('plan'));

        $company = $this->companyRepository->findOrFail($id);
        
        $errors = $this->subscriptionHelper->validateChangePlan($plan, $company);

        if (! count($errors)) {

            $recurringProfile = $this->subscriptionHelper->activateManualPlan($company, request()->all());

            session()->flash('success', trans('saassubscription::app.super-user.plans.plan-activated'));
        } else {
            session()->flash('warning', implode(' ', $errors));
        }

        return redirect()->back();
    }

    /**
     * Cancel recurring profile
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $recurringProfile = $this->recurringProfileRepository->findOrFail($id);

        try {
            $recurringProfile->state = 'Cancel';

            $result = $this->paypalHelper->updateRecurringProfileStatus($recurringProfile);

            if ($result['ACK']) {
                session()->flash('success', trans('saassubscription::app.super-user.plans.plan-activated'));
            } else {
                session()->flash('error', $result['msg']);
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('saassubscription::app.super-user.plans.general-error'));
        }

        return redirect()->back();
    }
}