<?php

namespace Webkul\StripeConnect\Payment;

/**
 * StripePayment method class
 *
 * @author    Prashant Singh <prashant.singh852@webkul.com> @prashant-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class StripePayment extends Stripe
{
    protected $code = 'stripe';

    /**
     * Get the Title fo Stripe Connect
     */
    public function getTitle()
    {
        return company()->getSuperConfigData('sales.paymentmethods.stripe.title') ?? 'Stripe';
    }

    /**
     * Get the Description fo Stripe Connect
     */
    public function getDescription()
    {
        return company()->getSuperConfigData('sales.paymentmethods.stripe.description') ?? 'Stripe Payment';
    }

    /**
     * Get the redirect url for redirecting to
     */
    public function getRedirectUrl()
    {
        return route('stripe.standard.redirect');
    }

    /**
     * Stripe web URL generic getter
     *
     * @param array $params
     * @return string
     */
    public function getStripeUrl($params = [])
    {
        $this->getRedirectUrl();
    }
}