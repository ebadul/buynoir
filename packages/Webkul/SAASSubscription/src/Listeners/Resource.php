<?php

namespace Webkul\SAASSubscription\Listeners;

use Webkul\SAASSubscription\Helpers\Subscription;

class Resource
{
    /**
     * Subscription object
     *
     * @var \Webkul\SAASSubscription\Helpers\Subscription
     */
    protected $subscriptionHelper;

    /**
     * Create a new listener instance.
     *
     * @param  \Webkul\SAASSubscription\Helpers\Subscription  $subscriptionHelper
     * @return void
     */
    public function __construct(Subscription $subscriptionHelper)
    {
        $this->subscriptionHelper = $subscriptionHelper;
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeProductCreate()
    {
        $this->subscriptionHelper->validateResource('products');
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeCategoryCreate()
    {
        $this->subscriptionHelper->validateResource('categories');
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeAttributeCreate()
    {
        $this->subscriptionHelper->validateResource('attributes');
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeAttributeFamilyCreate()
    {
        $this->subscriptionHelper->validateResource('attribute_families');
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeChannelCreate()
    {
        $this->subscriptionHelper->validateResource('channels');
    }

    /**
     * Validate resource creation based on current plan
     * 
     * @return void
     */
    public function beforeOrderCreate()
    {
        $this->subscriptionHelper->validateResource('orders');
    }
}