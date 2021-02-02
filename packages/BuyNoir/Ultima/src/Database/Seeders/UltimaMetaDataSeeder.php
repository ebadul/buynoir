<?php

namespace BuyNoir\Ultima\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UltimaMetaDataSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('ultima_meta_data')->delete();

        DB::table('ultima_meta_data')->insert(
            [
                'id'                       => 1,
                'locale'                   => 'en',

                'header_content_count'     => "5",
                'channel'                  => "default",
                'home_page_content'        => "<p>@include('shop::messages.shipping') @include('shop::home.advertisements.advertisement-four') @include('shop::home.advertisements.advertisement-two') <br />@include('shop::home.featured-products')@include('shop::home.advertisements.advertisement-one') @include('shop::home.advertisements.brand-slider')</p>",
                'footer_left_content'      => '<h3>Customer Service</h3><ul><li><a href="https://webkul.com/about-us/company-profile/">Order and Returns</a></li><li><a href="https://webkul.com/about-us/company-profile/">Payment Policy</a></li><li><a href="https://webkul.com/about-us/company-profile/">Shipping Policy</a></li><li><a href="https://webkul.com/about-us/company-profile/">Privacy and Cookies Policy</a></li></ul>',

                'footer_middle_content'    => '<div class="col-lg-6 col-md-12 col-sm-12 no-padding"><h3>About Us</h3><ul type="none"><li><a href="https://webkul.com/about-us/company-profile/">About Us</a></li><li><a href="https://webkul.com/about-us/company-profile/">Customer Service</a></li><li><a href="https://webkul.com/about-us/company-profile/">What&rsquo;s New</a></li><li><a href="https://webkul.com/about-us/company-profile/">Contact Us</a></li></ul></div><div class="col-lg-6 col-md-12 col-sm-12 no-padding"><ul type="none"></ul></div>',
                'slider'                   => 1,

                'subscription_bar_content' => '<h2 class="text-center">BE THE FIRST TO KNOW</h2><p class="text-center">Subscribe to our newsletter to receive exclusive emails, offers and more.</p>',

                'product_policy'           => '<h3>Our Promise</h3><ul><li>Free International Shipping</li><li>Free Returns</li><li>100% Genuine Products</li><li>24/7 Customer Support</li></ul>',
            ]
        );


        DB::table('core_config')->insert([
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'en',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'fr',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'ar',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'de',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'es',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'fa',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'it',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'ja',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'nl',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'pl',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'pt_BR',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'code'         => 'general.content.shop.compare_option',
                'company_id'        => '25',
                'value'        => '1',
                'channel_code' => 'default',
                'locale_code'  => 'tr',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
