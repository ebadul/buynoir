<?php

namespace Webkul\SAASSubscription\Http\Controllers\Super;

use Illuminate\Support\Facades\Event;
use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Repositories\PlanRepository;
use Webkul\SAASCustomizer\Facades\Company;

class PlanController extends Controller
{
    /**
     * PlanRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\PlanRepository
     */
    protected $planRepository;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'code'                       => [
                                                'required',
                                                'unique:saas_subscription_plans,code',
                                                new \Webkul\Core\Contracts\Validations\Code
                                            ],
            'name'                       => 'required',
            'monthly_amount'             => 'required|numeric|min:0',
            'yearly_amount'              => 'required|numeric|min:0',
            'allowed_products'           => 'required|integer|min:1',
            'allowed_categories'         => 'required|integer|min:1',
            'allowed_attributes'         => 'required|integer|min:1',
            'allowed_attribute_families' => 'required|integer|min:1',
            'allowed_channels'           => 'required|integer|min:1',
            'allowed_orders'             => 'required|integer|min:1',
        ]);

        Event::dispatch('super.subscription.plan.create.before');

        $plan = $this->planRepository->create(request()->all());

        Event::dispatch('super.subscription.plan.create.after', $plan);

        session()->flash('success', trans('saassubscription::app.super-user.plans.create-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $plan = $this->planRepository->findOrFail($id);

        return view($this->_config['view'], compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'code'                       => [
                                            'required',
                                            'unique:saas_subscription_plans,code,' . $id,
                                            new \Webkul\Core\Contracts\Validations\Code,
                                        ],
            'name'                       => 'required',
            'monthly_amount'             => 'required|numeric|min:0',
            'yearly_amount'              => 'required|numeric|min:0',
            'allowed_products'           => 'required|integer|min:1',
            'allowed_categories'         => 'required|integer|min:1',
            'allowed_attributes'         => 'required|integer|min:1',
            'allowed_attribute_families' => 'required|integer|min:1',
            'allowed_channels'           => 'required|integer|min:1',
            'allowed_orders'             => 'required|integer|min:1',
        ]);

        Event::dispatch('super.subscription.plan.update.before', $id);

        $plan = $this->planRepository->update(request()->all(), $id);

        Event::dispatch('super.subscription.plan.update.after', $plan);

        session()->flash('success', trans('saassubscription::app.super-user.plans.update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = $this->planRepository->findOrFail($id);

        try {
            Event::dispatch('super.subscription.plan.delete.before', $id);

            $this->planRepository->delete($id);

            Event::dispatch('super.subscription.plan.delete.after', $id);

            session()->flash('success', trans('saassubscription::app.super-user.plans.delete-success'));

            return response()->json(['message' => true], 200);
        } catch(\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Plan']));
        }

        return response()->json(['message' => false], 400);
    }
}