<?php

namespace BuyNoir\SuperFront\Http\Controllers;

use BuyNoir\SuperFront\Http\Controllers\Controller;

/**
 * Landing page controller
 *
 * @author    Fakhrul Islam Shahin <shahin2k5@gmail.com> @shahin-buynoir
 * @copyright 2020 BuyNoir Software Pvt Ltd (http://www.buynoir.co)
 */
 class SuperFrontController extends Controller
{

    protected $_config;
 

     
    public function __construct()
    { 
        $this->_config = request('_config');
    }

    /**
     * loads the home page for the storefront
     * 
     * @return \Illuminate\View\View 
     */
    public function index()
    {
        // $currentChannel = company()->getCurrentChannel();
        // $sliderData = $this->sliderRepository->findByField('channel_id', $currentChannel->id)->toArray();
        return view($this->_config['view']);
    }

    /**
     * loads the home page for the storefront
     */
  
}