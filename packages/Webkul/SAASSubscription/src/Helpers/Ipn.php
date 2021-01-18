<?php

namespace Webkul\SAASSubscription\Helpers;

use Webkul\SAASSubscription\Repositories\RecurringProfileRepository;
use Webkul\SAASSubscription\Repositories\InvoiceRepository;

class Ipn
{
    /**
     * RecurringProfileRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\RecurringProfileRepository
     */
    protected $recurringProfileRepository;

    /**
     * InvoiceRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * InvoiceRepository object
     *
     * @var \Webkul\SAASSubscription\Helpers\Paypal
     */
    protected $paypalHelper;

    /**
     * InvoiceRepository object
     *
     * @var \Webkul\SAASSubscription\Helpers\Subscription
     */
    protected $subscriptionHelper;

    /**
     * RecurringProfile object
     *
     * @var \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    protected $recurringProfile;

    /**
     *
     * @var array
     */
    protected $post;

    /**
     * Create a new helper instance.
     *
     * @param  \Webkul\SAASSubscription\Repositories\RecurringProfileRepository  $recurringProfileRepository
     * @param  \Webkul\SAASSubscription\Repositories\InvoiceRepository  $invoiceRepository
     * @param  \Webkul\SAASSubscription\Helpers\Paypal  $paypalHelper
     * @param  \Webkul\SAASSubscription\Helpers\Subscription  $subscriptionHelper
     * @return void
     */
    public function __construct(
        RecurringProfileRepository $recurringProfileRepository,
        InvoiceRepository $invoiceRepository,
        Paypal $paypalHelper,
        Subscription $subscriptionHelper
    )
    {
        $this->recurringProfileRepository = $recurringProfileRepository;

        $this->invoiceRepository = $invoiceRepository;

        $this->paypalHelper = $paypalHelper;

        $this->subscriptionHelper = $subscriptionHelper;
    }

    /**
     * Process ipn request comimg from paypal
     *
     * @var  array  $data
     * @return void|null
     */
    public function processIpnRequest($data)
    {
        $this->post = $data;
        
        $recurringProfile = $this->getRecurringProfile();


        if (! $recurringProfile) {
            return;
        }

        if (! $this->_postBack()) {
            return;
        }

        try {
            if (isset($this->post['txn_type'])
                && 'recurring_payment_suspended_due_to_max_failed_payment' == $this->post['txn_type']
            ) {
                if ($lastInvoiceId = $recurringProfile->saas_subscription_invoice_id) {
                    $this->invoiceRepository->update([
                        'status' => 'Failed',
                    ], $lastInvoiceId);
                }

                $this->recurringProfileRepository->update([
                    'state'          => $this->paypalHelper->getProfileState($this->post['profile_status']),
                    'payment_status' => 'Failed',
                ], $recurringProfile->id);

                //Send email to company
            } elseif (isset($this->post['txn_type'])
                      && 'recurring_payment_suspended' == $this->post['txn_type']
            ) {
                $this->recurringProfileRepository->update([
                    'state' => $this->paypalHelper->getProfileState($this->post['profile_status']),
                ], $recurringProfile->id);
            } elseif (isset($this->post['txn_type'])
                      && 'recurring_payment_profile_cancel' == $this->post['txn_type']
            ) {
                $this->recurringProfileRepository->update([
                    'state'         => $this->paypalHelper->getProfileState($this->post['profile_status']),
                    'next_due_date' => null,
                ], $recurringProfile->id);
            } elseif (isset($this->post['txn_type'])
                      && 'recurring_payment_skipped' == $this->post['txn_type']
            ) {
                // Recurring payment skipped; it will be retried up to 3 times, 5 days apart
                $days  = 0;

                if ($recurringProfile->payment_method != 'Skipped') {
                    $days = 5;

                    $invoice = $this->subscriptionHelper->createInvoice([
                        'recurring_profile'                      => $recurringProfile,
                        'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                        'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                        'grand_total'                            => $recurringProfile->amount,
                        'customer_email'                         => $recurringProfile->company->email,
                        'customer_name'                          => $recurringProfile->company->username,
                        'payment_method'                         => 'Paypal',
                        'status'                                 => 'Skipped',
                    ]);
                    
                    $this->recurringProfileRepository->update([
                        'payment_status'               => 'Skipped',
                        'saas_subscription_invoice_id' => $invoice->id,
                    ], $recurringProfile->id);
                }

                //send email to company
            } elseif (isset($this->post['txn_type'])
                      && 'recurring_payment' == $this->post['txn_type']
                      && $this->post['payment_status'] == "Pending"
            ) {
                if ($recurringProfile->payment_status != 'Skipped') {
                    $invoice = $this->subscriptionHelper->createInvoice([
                        'recurring_profile'                      => $recurringProfile,
                        'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                        'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                        'grand_total'                            => $this->post['mc_gross'],
                        'customer_email'                         => $recurringProfile->company->email,
                        'customer_name'                          => $recurringProfile->company->username,
                        'payment_method'                         => 'Paypal',
                        'status'                                 => 'Pending',
                        'pending_reason'                         => $this->post['pending_reason'],
                    ]);
                } else {
                    $data = [
                        'status'         => 'Pending',
                        'payment_method' => 'Paypal',
                    ];

                    if (isset($this->post['pending_reason'])) {
                        $data['pending_reason'] = $this->post['pending_reason'];
                    }
                    
                    $this->invoiceRepository->update($data, $recurringProfile->saas_subscription_invoice_id);
                }

                $this->recurringProfileRepository->update([
                    'payment_status'               => 'Pending',
                    'saas_subscription_invoice_id' => isset($invoice)
                                                      ? $invoice->id
                                                      : $recurringProfile->saas_subscription_invoice_id,
                ], $recurringProfile->id);
            } elseif (isset($this->post['txn_type'])
                      && 'recurring_payment' == $this->post['txn_type']
            ) {
                $invoice = $this->invoiceRepository->findOneByField('transaction_id', $this->post['txn_id']);

                if ($invoice) {
                    return;
                }

                $nextDueDate = $this->subscriptionHelper->getNextDueDate($recurringProfile);

                if ($recurringProfile->payment_status != 'Skipped'
                    && $recurringProfile->payment_status != 'Pending'
                ) {
                    $invoice = $this->subscriptionHelper->createInvoice([
                        'recurring_profile'                      => $recurringProfile,
                        'saas_subscription_purchased_plan_id'    => $recurringProfile->purchased_plan->id,
                        'saas_subscription_recurring_profile_id' => $recurringProfile->id,
                        'grand_total'                            => $this->post['mc_gross'],
                        'cycle_expired_on'                       => $nextDueDate,
                        'customer_email'                         => $recurringProfile->company->email,
                        'customer_name'                          => $recurringProfile->company->username,
                        'payment_method'                         => 'Paypal',
                        'status'                                 => 'Success',
                        'transaction_id'                         => $this->post['txn_id'],
                    ]);
                } else {
                    $this->invoiceRepository->update([
                        'cycle_expired_on' => $nextDueDate,
                        'status'           => 'Success',
                        'payment_method'   => 'Paypal',
                    ], $recurringProfile->saas_subscription_invoice_id);
                }
                
                $this->recurringProfileRepository->update([
                    'next_due_date'                => $nextDueDate,
                    'cycle_expired_on'             => $nextDueDate,
                    'payment_status'               => 'Success',
                    'saas_subscription_invoice_id' => isset($invoice)
                                                      ? $invoice->id
                                                      : $recurringProfile->saas_subscription_invoice_id,
                ], $recurringProfile->id);
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Returns recurring profile
     *
     * @return \Webkul\SAASSubscription\Contracts\RecurringProfile
     */
    public function getRecurringProfile()
    {
        if (! $this->recurringProfile) {
            $this->recurringProfile = $this->recurringProfileRepository->findOneByField(
                'reference_id', $this->post['recurring_payment_id']
            );
        }

        return $this->recurringProfile;
    }

    /**
     * Returns recurring profile
     *
     * @return void
     */
    protected function _postBack()
    {
        if(array_key_exists('test_ipn', $this->post) && 1 === (int) $this->post['test_ipn']) {
            $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $url = 'https://www.paypal.com/cgi-bin/webscr';
        }

        // Set up request to PayPal
        $request = curl_init();

        curl_setopt_array($request, array
        (
            CURLOPT_URL            => $url,
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => http_build_query(array('cmd' => '_notify-validate') + $this->post),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER         => FALSE,
        ));

        // Execute request and get response and status code
        $response = curl_exec($request);
        $status   = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($request);

        if ($status == 200 && $response == 'VERIFIED') {
            return true;
        } else {
            return false;
        }
    }
}