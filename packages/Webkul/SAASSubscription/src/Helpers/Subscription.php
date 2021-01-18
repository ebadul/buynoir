<?php

namespace Webkul\SAASSubscription\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Webkul\SAASCustomizer\Repositories\Super\CompanyRepository;
use Webkul\SAASSubscription\Repositories\PlanRepository;
use Webkul\SAASSubscription\Repositories\RecurringProfileRepository;
use Webkul\SAASSubscription\Repositories\AddressRepository;
use Webkul\SAASSubscription\Repositories\PurchasedPlanRepository;
use Webkul\SAASSubscription\Repositories\InvoiceRepository;
use Webkul\SAASCustomizer\Facades\Company;

class Subscription
{
    /**
     * CompanyRepository object
     *
     * @var \Webkul\SAASCustomizer\Repositories\Super\CompanyRepository
     */
    protected $companyRepository;

    /**
     * PlanRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\PlanRepository
     */
    protected $planRepository;

    /**
     * RecurringProfileRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\RecurringProfileRepository
     */
    protected $recurringProfileRepository;

    /**
     * AddressRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\AddressRepository
     */
    protected $addressRepository;

    /**
     * PurchasedPlanRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\PurchasedPlanRepository
     */
    protected $purchasedPlanRepository;

    /**
     * InvoiceRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * Create a new helper instance.
     *
     * @param  \Webkul\SAASCustomizer\Repositories\Super\CompanyRepository  $companyRepository
     * @param  \Webkul\SAASSubscription\Repositories\PlanRepository  $planRepository
     * @param  \Webkul\SAASSubscription\Repositories\RecurringProfileRepository  $recurringProfileRepository
     * @param  \Webkul\SAASSubscription\Repositories\AddressRepository  $addressRepository
     * @param  \Webkul\SAASSubscription\Repositories\PurchasedPlanRepository  $purchasedPlanRepository
     * @param  \Webkul\SAASSubscription\Repositories\InvoiceRepository  $invoiceRepository
     * @return void
     */
    public function __construct(
        CompanyRepository $companyRepository,
        PlanRepository $planRepository,
        RecurringProfileRepository $recurringProfileRepository,
        AddressRepository $addressRepository,
        PurchasedPlanRepository $purchasedPlanRepository,
        InvoiceRepository $invoiceRepository
    )
    {
        $this->companyRepository = $companyRepository;

        $this->planRepository = $planRepository;

        $this->recurringProfileRepository = $recurringProfileRepository;

        $this->addressRepository = $addressRepository;

        $this->purchasedPlanRepository = $purchasedPlanRepository;

        $this->invoiceRepository = $invoiceRepository;
    }

    /**
     * Retunns company's current recurring profile
     * 
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function getCurrentRecurringProfile($company = null)
    {
        $company = ! empty($company) ? $company : Company::getCurrent();

        $recurringProfile = $this->recurringProfileRepository->where('company_id', $company->id)->latest()->first();

        return $recurringProfile;
    }

    /**
     * Activates trial plan
     * 
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function activateTrial($company = null)
    {
        $company = $company ? $company : Company::getCurrent();

        if (! company()->getSuperConfigData('subscription.payment.general.allow_trial')
            || ! company()->getSuperConfigData('subscription.payment.general.trial_days')
        ) {
            return;
        }

        $plan = $this->planRepository->find(company()->getSuperConfigData('subscription.payment.general.trial_plan'));

        if (! $plan) {
            return;
        }

        DB::beginTransaction();

        try {
            $cycleExpiredOn = Carbon::now();

            $cycleExpiredOn->addDays(company()->getSuperConfigData('subscription.payment.general.trial_days'));

            $cart = [
                'plan'             => $plan,
                'amount'           => 0,
                'period_unit'      => 'month',
                'customer_email'   => $company->email,
                'customer_name'    => $company->username,
                'type'             => 'trial',
                'cycle_expired_on' => $cycleExpiredOn,
                'next_due_date'    => NULL,
                'payment_status'   => 'Success',
                'company'          => $company,
            ];

            session()->put('subscription_cart', $cart);

            $recurringProfile = $this->createRecurringProfile([
                'PROFILESTATUS' => 'ActiveProfile',
                'PROFILEID'     => NULL,
                'company'       => $company
            ]);

            $invoice = $this->createInvoice([
                'recurring_profile'                      => $recurringProfile,
                'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                'grand_total'                            => 0,
                'cycle_expired_on'                       => $cycleExpiredOn,
                'customer_email'                         => $recurringProfile->company->email,
                'customer_name'                          => $recurringProfile->company->username,
                'payment_method'                         => 'Paypal',
                'status'                                 => 'Success',
            ]);

            $this->recurringProfileRepository->update([
                'saas_subscription_invoice_id' => $invoice->id
            ], $recurringProfile->id);
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $recurringProfile;
    }

    /**
     * Activates manual plan
     * 
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @param  array  $data
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function activateManualPlan($company, $data)
    {
        DB::beginTransaction();

        try {
            $plan = $this->planRepository->find($data['plan']);

            $cart = [
                'plan'             => $plan,
                'amount'           => $data['period_unit'] == 'month'
                                      ? $plan->monthly_amount
                                      : $plan->yearly_amount * 12,
                'period_unit'      => $data['period_unit'],
                'customer_email'   => $company->email,
                'customer_name'    => $company->username,
                'type'             => 'manual',
                'payment_status'   => 'Success',
                'cycle_expired_on' => null,
                'company'          => $company,
            ];

            session()->put('subscription_cart', $cart);

            $recurringProfile = $this->createRecurringProfile([
                'PROFILESTATUS' => 'ActiveProfile',
                'PROFILEID'     => NULL,
                'company'       => $company
            ]);

            $nextDueDate = $this->getNextDueDate($recurringProfile);

            $invoice = $this->createInvoice([
                'recurring_profile'                      => $recurringProfile,
                'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                'grand_total'                            => $recurringProfile->amount,
                'cycle_expired_on'                       => $nextDueDate,
                'customer_email'                         => $recurringProfile->company->email,
                'customer_name'                          => $recurringProfile->company->username,
                'payment_method'                         => 'Manual',
                'status'                                 => 'Success',
            ]);

            $this->recurringProfileRepository->update([
                'saas_subscription_invoice_id' => $invoice->id,
                'cycle_expired_on'             => $nextDueDate,
                'next_due_date'                => $nextDueDate,
            ], $recurringProfile->id);
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $recurringProfile;
    }

    /**
     * Activates free plan
     * 
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function activateFreePlan($company = null)
    {
        $company = $company ? $company : Company::getCurrent();

        $plan = session()->get('subscription_cart.plan');

        DB::beginTransaction();

        try {
            $cart = [
                'plan'             => $plan,
                'amount'           => 0,
                'period_unit'      => 'infinite',
                'customer_email'   => $company->email,
                'customer_name'    => $company->username,
                'type'             => 'free',
                'payment_status'   => 'Success',
                'company'          => $company,
            ];

            session()->put('subscription_cart', $cart);

            $recurringProfile = $this->createRecurringProfile([
                'PROFILESTATUS' => 'ActiveProfile',
                'PROFILEID'     => NULL,
                'company'       => $company
            ]);

            $invoice = $this->createInvoice([
                'recurring_profile'                      => $recurringProfile,
                'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                'grand_total'                            => 0,
                'customer_email'                         => $recurringProfile->company->email,
                'customer_name'                          => $recurringProfile->company->username,
                'payment_method'                         => 'Free',
                'status'                                 => 'Success',
            ]);

            $this->recurringProfileRepository->update([
                'saas_subscription_invoice_id' => $invoice->id
            ], $recurringProfile->id);
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $recurringProfile;
    }

    /**
     * Creates recurring profiles
     * 
     * @param  array  $response
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function createRecurringProfile($response)
    {
        $cart = session()->get('subscription_cart');

        $company = $response['company'] ?? Company::getCurrent();

        $data = [];

        if ($cart['type'] == 'manual') {
            $data['payment_status'] = 'Success';
        } elseif ($cart['type'] != 'free') {
            if ($cart['type'] == 'trial') {
                $data['cycle_expired_on'] = $cart['cycle_expired_on'];
            } else {
                $data['next_due_date'] = Carbon::now();
                $data['payment_status'] = 'Payment Due';
            }
        }

        $currentRecurringProfile = $this->getCurrentRecurringProfile($company);
        
        $cart['recurring_profile'] = $recurringProfile = $this->recurringProfileRepository->create(array_merge($data, [
            'type'                 => $cart['type'],
            'state'                => app(Paypal::class)->getProfileState($response['PROFILESTATUS']),
            'reference_id'         => $response['PROFILEID'],
            'schedule_description' => $cart['plan']->name,
            'period_unit'          => $cart['period_unit'],
            'amount'               => $cart['amount'],
            'company_id'           => $company->id,
            'tin'                  => isset($cart['tin']) ? $cart['tin'] : null, 
        ]));

        if (isset($cart['address'])) {
            $this->addressRepository->create(array_merge($cart['address'], [
                'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                'company_id'                             => $recurringProfile->company_id,
            ]));
        }  
        
        $purchasedPlan = $this->createPurchasedPlan($cart);

        if ($currentRecurringProfile) {
            $currentRecurringProfile->state = 'Cancel';

            if ($currentRecurringProfile->type == 'paypal') {
                app(Paypal::class)->updateRecurringProfileStatus($currentRecurringProfile);
            }
            
            $this->recurringProfileRepository->update([
                'state' => 'Cancelled',
            ], $currentRecurringProfile->id);
            
        }

        return $recurringProfile;
    }

    /**
     * Creates invoice
     * 
     * @param  array  $data
     * @return \Webkul\SAASSubscription\Contracts\Invoice
     */
    public function createInvoice($data)
    {
        $data['invoice'] = $invoice = $this->invoiceRepository->create(array_merge($data, [
            'company_id' => $data['recurring_profile']->company_id
        ]));

        if ($data['recurring_profile']->billing_address) {
            $data['billing_address'] = $data['recurring_profile']->billing_address->toArray();
        }

        if (isset($data['billing_address'])) {
            $addressData = Arr::except($data['billing_address'], [
                'saas_subscription_recurring_profile_id',
            ]);

            $this->addressRepository->create(array_merge($addressData, [
                'saas_subscription_invoice_id' => $invoice->id,
                'company_id'                   => $invoice->company_id,
            ]));
        }

        if (! in_array($data['recurring_profile']->type, ['trial', 'free'])
            && $data['status'] == "Success"
        ) {
            //Send mail to tenent
        }
        
        return $invoice;
    }

    /**
     * Creates purchased plan
     * 
     * @param  array  $cart
     * @return \Webkul\SAASSubscription\Contracts\PurchasedPlan
     */
    public function createPurchasedPlan($cart)
    {
        $purchasedPlan = $this->purchasedPlanRepository->create(array_merge($cart['plan']->toArray(), [
            'saas_subscription_recurring_profile_id' => $cart['recurring_profile']->id,
            'company_id'                             => $cart['recurring_profile']->company_id
        ]));

        return $purchasedPlan;
    }

    /**
     * Returns next due date for payment
     * 
     * @param  \Webkul\SAASSubscription\Contracts\RecurringProfile  $recurringProfile
     * @return \Carbon\Carbon
     */
    public function getNextDueDate($recurringProfile)
    {
        $lastDueDate = $recurringProfile->next_due_date
                       ? clone $recurringProfile->next_due_date
                       : Carbon::now();

        if ($recurringProfile->period_unit == 'month') {
            $lastDueDateDay = $lastDueDate->format('d');
            
            $lastDueDate->modify('last day of next month');
            
            $lastDayOfNextMonth = $lastDueDate->format('d');
           
            if (in_array($lastDueDateDay, [29, 30, 31]) && $lastDayOfNextMonth < $lastDueDateDay) {
                $lastDueDate->modify( 'first day of next month' );

                return Carbon::createFromTimeString($lastDueDate->format('Y-m-d 23:59:59'));
            } else {
                $lastDueDate = $recurringProfile->next_due_date
                               ? $recurringProfile->next_due_date
                               : Carbon::now();

                $lastDueDate->addMonth();

                return Carbon::createFromTimeString($lastDueDate->format('Y-m-d 23:59:59'));
            }
        } else {
            $lastDueDate->addYear();

            return Carbon::createFromTimeString($lastDueDate->format('Y-m-d 23:59:59'));
        }
    }

    /**
     * Checks if company is expired or not
     * 
     * @param  int  $companyId
     * @return bool
     */
    public function isExpired($companyId)
    {
        $recurringProfile = $this->getCurrentRecurringProfile();

        if (! $recurringProfile) {
            return false;
        }
        
        $currentDateTime = Carbon::now();
        
        if (! $recurringProfile->cycle_expired_on) {
            return false;
        }

        $expirationDate = clone $recurringProfile->cycle_expired_on;

        $isExpired = $currentDateTime->getTimestamp() >= $expirationDate->getTimestamp() ? true : false;

        if ($isExpired && $recurringProfile->payment_status != "Payment Due") {
            $this->recurringProfileRepository->update([
                'payment_status' => 'Payment Due'
            ], $recurringProfile->id);
        }
        
        return $isExpired;
    }

    /**
     * Checks if company service is stopped or not
     * 
     * @param  int|null  $companyId
     * @return bool
     */
    public function isServiceStopped($companyId = null)
    {
        $recurringProfile = $this->getCurrentRecurringProfile();

        if (! $recurringProfile) {
            return true;
        }
        
        $company = $companyId
                   ? $this->companyRepository->find($companyId)
                   : Company::getCurrent();

        //For setting Payment Due status
        $this->isExpired($company->id);

        if ($recurringProfile->type == 'free') {
            return false;
        }

        $currentDateTime = Carbon::now();

        $expirationDate = $recurringProfile->cycle_expired_on
                          ? clone $recurringProfile->cycle_expired_on
                          : clone $recurringProfile->created_at;

        if ($recurringProfile->state == 'Active'
            && ! in_array($recurringProfile->type, ['trial', 'manual'])
        ) {
            if ($recurringProfile->payment_status == 'Skipped') {
                $expirationDate->addDays(5);  
            } else {
                $expirationDate->addDays(1);
            }
        }
        
        return $currentDateTime->getTimestamp() >= $expirationDate->getTimestamp() ? true : false;
    }

    /**
     * Returns formated plans for checkout process
     * 
     * @return array
     */
    public function getFormatedPlans()
    {
        $currencySymbol = config('app.currency');

        $data = [];

        foreach ($this->planRepository->all() as $plan) {
            if (! (float) $plan->monthly_amount) {
                continue;
            }

            $data['month'][$plan->id] = [
                'id'     => $plan->id,
                'name'   => $plan->name,
                'label'  => trans('saassubscription::app.admin.checkout.plan-option-label', [
                                'plan'   => $plan->name,
                                'amount' => core()->formatPrice($plan->monthly_amount, $currencySymbol)
                            ]),
                'amount' => core()->formatPrice($plan->monthly_amount, $currencySymbol),
                'total'  => core()->formatPrice($plan->monthly_amount, $currencySymbol),
            ];

            $data['year'][$plan->id] = [
                'id'     => $plan->id,
                'name'   => $plan->name,
                'label'  => trans('saassubscription::app.admin.checkout.plan-option-label', [
                                'plan'   => $plan->name,
                                'amount' => core()->formatPrice($plan->yearly_amount, $currencySymbol)
                            ]),
                'amount' => core()->formatPrice($plan->yearly_amount, $currencySymbol),
                'total'  => core()->formatPrice($plan->yearly_amount * 12, $currencySymbol),
            ];
        }

        return $data;
    }

    /**
     * Get remaining resource to create
     * 
     * @param  string  $tableName
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @return void
     */
    public function getUsedResources($tableName, $company = null)
    {
        $company = $company ?: Company::getCurrent();

        switch ($tableName) {
            case 'orders':
                $recurringProfile = $this->getCurrentRecurringProfile($company);

                if ($recurringProfile) {
                    $lastDate = $recurringProfile->cycle_expired_on
                                ? $recurringProfile->cycle_expired_on
                                : $recurringProfile->next_due_date;

                    if (! $lastDate) {
                        $lastDate = Carbon::now();
                    }

                    return DB::table($tableName)
                        ->where('company_id', $company->id)
                        ->where('created_at', '>', $lastDate->subDays(30))
                        ->where('created_at', '<', Carbon::now())
                        ->count();
                }
            default:
                return DB::table($tableName)
                    ->where('company_id', $company->id)
                    ->count();
        }
    }

    /**
     * Get remaining resource to create
     * 
     * @param  string  $tableName
     * @return void
     */
    public function getLeftResources($tableName = null)
    {
        $recurringProfile = $this->getCurrentRecurringProfile();

        if (! $recurringProfile) {
            return;
        }

        $purchasedPlan = $recurringProfile->purchased_plan;

        $resources = [
            'products' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_products,
                'used'         => $used = $this->getUsedResources('products'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.product-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ],

            'categories' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_categories,
                'used'         => $used = $this->getUsedResources('categories'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.category-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ],

            'attributes' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_attributes,
                'used'         => $used = $this->getUsedResources('attributes'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.attribute-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ],

            'attribute_families' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_attribute_families,
                'used'         => $used = $this->getUsedResources('attribute_families'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.attribute-family-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ],

            'channels' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_channels,
                'used'         => $used = $this->getUsedResources('channels'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.channel-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ],

            'orders' => [
                'purchased'    => $purchased = $purchasedPlan->allowed_orders,
                'used'         => $used = $this->getUsedResources('orders'),
                'remaining'    => $remaining = $purchased - $used,
                'allow'        => $remaining <= 0 ? false : true,
                'message'      => trans('saassubscription::app.admin.plans.order-left-notification', [
                                    'remaining' => $remaining,
                                    'purchased' => $purchased,
                                  ]),
            ]
        ];

        if ($tableName) {
            return $resources[$tableName];
        }

        return $resources;
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @param  string  $tableName
     * @return void|bool
     */
    public function validateResource($tableName)
    {
        if (request()->route()->getName() == 'company.create.data') {
            return;
        }

        $resources = $this->getLeftResources($tableName);

        if (! $resources) {
            throw new \Webkul\SAASSubscription\Exceptions\ResourceLimitExceed(trans('saassubscription::app.admin.layouts.purchase-plan-notification'), 403);
        }

        if ($tableName == 'products' && request('type') == 'configurable') {
            $requestedProducts = count(array_permutation(request('super_attributes'))) + 1;

            if ($resources['remaining'] >= $requestedProducts) {
                return true;                
            }
        } elseif ($resources['allow']) {
            return true;
        }

        throw new \Webkul\SAASSubscription\Exceptions\ResourceLimitExceed($resources['message'], 403);
    }

    /**
     * Validate plan for checkout
     * 
     * @param  \Webkul\SAASSubscription\Contracts\Plan  $plan
     * @param  \Webkul\SAASCustomizer\Contracts\Company  $company
     * @return array
     */
    public function validateChangePlan($plan, $company = null)
    {
        $entities = [
            'products',
            'categories',
            'attributes',
            'attribute_families',
            'channels',
            'orders',
        ];

        $errors = [];

        foreach ($entities as $tableName) {
            $used = $this->getUsedResources($tableName, $company);

            if ($used > ($allowed = $plan->{'allowed_' . $tableName})) {
                $errors[] = trans('saassubscription::app.admin.plans.resource-limit-error', [
                    'entity_name' => trans('saassubscription::app.admin.plans.' . $tableName),
                    'allowed'     => $allowed,
                    'used'        => $used,
                ]);
            }
        }

        return $errors;
    }
}