@extends('superfront_view::superfront.layouts.master')

@php
    $channel = company()->getCurrentChannel();
    
    if ( $channel ) {
        $homeSEO = $channel->home_seo;

        if (isset($homeSEO)) {
            $homeSEO = json_decode($channel->home_seo);

            $metaTitle = $homeSEO->meta_title;

            $metaDescription = $homeSEO->meta_description;

            $metaKeywords = $homeSEO->meta_keywords;
        }
    }
@endphp

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif
@endsection



@section('content-wrapper')

    {!! view_render_event('bagisto.saas.companies.home.content.before') !!}

    <div id="wrapper">
        <div id="content">
          <!-- Stat main -->
          <main data-spy="scroll" data-target="#navbar-example2" data-offset="0">
            <!-- Start Banner Section -->
            <section class="demo_1 demo__charity demo__software" id="About">
              <div class="container">
                <div class="row">
                  <div class="col-md-8 col-lg-5">
                    <div class="banner_title">
                      <div class="offer">
                        <span></span>
                        <span></span>
                      </div>
                      <h1 class="c-white">
                        Made to help
                        Black and Brown 
                        online Businesses
                        Sell and Grow
                      </h1>
                      <p>

                      </p>
                      <a href="{{route('company.create.index')}}" class="btn btn_lg_primary bg-green2 c-white sweep_top sweep_letter rounded-12">
                        <div class="inside_item">
                          <span data-hover="Yes, Free!">Start Free!</span>
                        </div>
                      </a>
    
                   
    
                    </div>
                  </div>
    
                  <div class="col-lg-6">
                    <div class="element_ui">
                    </div>
                  </div>
                </div>
              </div>
    
    
    
            </section>
            <!-- End Banner -->
    
            <!-- Start serv_soft -->
            <section class="services_section save__nature serv_soft padding-t-12" id="Features">
              <div class="container">
                <div class="row justify-content-center text-center">
                  <div class="col-md-8 col-lg-5">
                    <div class="title_sections">
                      <div class="before_title">
                        <span>Made for your </span>
                        <span class="c-green2">Black Business</span>
                      </div>
                      <h2>BuyNoir was built to help your online business grow.</h2>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-lg-3 item__nature">
                    <div class="items_serv sevice_block mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="0">
                      <div class="icon--top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26.824" height="23.192" viewBox="0 0 26.824 23.192">
                          <g id="Group_6272" data-name="Group 6272" transform="translate(-0.118 -3.632)">
                            <path id="Rectangle-154"
                              d="M2.343,2.343V4.686H8.2V2.343ZM1.171,0H24.6a1.171,1.171,0,0,1,1.171,1.171V5.857A1.171,1.171,0,0,1,24.6,7.028H1.171A1.171,1.171,0,0,1,0,5.857V1.171A1.171,1.171,0,0,1,1.171,0Z"
                              transform="translate(23.31 8.602) rotate(135)" fill="#31d1ab" />
                            <path id="Combined-Shape"
                              d="M17.586,12.514h1.171a.586.586,0,0,1,.586.586v1.171a.586.586,0,0,1-.586.586H17.586A.586.586,0,0,1,17,14.271V13.1A.586.586,0,0,1,17.586,12.514ZM21.1,9h1.171a.586.586,0,0,1,.586.586v1.171a.586.586,0,0,1-.586.586H21.1a.586.586,0,0,1-.586-.586V9.586A.586.586,0,0,1,21.1,9Zm1.171,4.686h1.171a.586.586,0,0,1,.586.586v1.171a.586.586,0,0,1-.586.586H22.271a.586.586,0,0,1-.586-.586V14.271A.586.586,0,0,1,22.271,13.686Z"
                              transform="translate(2.914 1.543)" fill="#31d1ab" fill-rule="evenodd" opacity="0.3" />
                          </g>
                        </svg>
    
                      </div>
                      <div class="txt">
                        <h3>    Built black for your black business</h3>
                        <p>
                            BuyNoir was <b>built by black entrepenures</b> for black entrepenures and makers.
                        </p>
                      </div>
    
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 item__nature mx-lg-auto">
                    <div class="items_serv sevice_block mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                      <div class="icon--top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                          <g id="Group_6273" data-name="Group 6273" transform="translate(-4.896 -4.896)">
                            <rect id="Rectangle-7" width="4" height="4" rx="2" transform="translate(4.896 4.896)"
                              fill="#d6c0b7" opacity="0.3" />
                            <rect id="Rectangle-7-Copy-3" width="4" height="4" rx="2" transform="translate(4.896 11.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy" width="4" height="4" rx="2" transform="translate(11.896 4.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-4" width="4" height="4" rx="2" transform="translate(11.896 11.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-2" width="4" height="4" rx="2" transform="translate(18.896 4.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-5" width="4" height="4" rx="2" transform="translate(18.896 11.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-8" width="4" height="4" rx="2" transform="translate(4.896 18.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-7" width="4" height="4" rx="2" transform="translate(11.896 18.896)"
                              fill="#d6c0b7" />
                            <rect id="Rectangle-7-Copy-6" width="4" height="4" rx="2" transform="translate(18.896 18.896)"
                              fill="#d6c0b7" />
                          </g>
                        </svg>
                      </div>
                      <div class="txt">
                        <h3>Everything you'll need</h3>
                        <p>
                          We listened to <b>hundreds of black owned small businesses</b> like yours and built the tools you'll need to sell more.
                        </p>
                      </div>
    
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 item__nature">
                    <div class="items_serv sevice_block mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                      <div class="icon--top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21.085" height="21.085" viewBox="0 0 21.085 21.085">
                          <g id="Group_6274" data-name="Group 6274" transform="translate(-3.514 -3.514)">
                            <rect id="Rectangle-62-Copy" width="3.514" height="15.228" rx="1.5"
                              transform="translate(14.057 4.686)" fill="#d6c0b7" opacity="0.3" />
                            <rect id="Rectangle-62-Copy-2" width="3.514" height="9.371" rx="1.5"
                              transform="translate(8.2 10.543)" fill="#d6c0b7" opacity="0.3" />
                            <path id="Path-95"
                              d="M5.343,21.742H22.914a1.171,1.171,0,0,1,0,2.343H4.171A1.171,1.171,0,0,1,3,22.914V4.171a1.171,1.171,0,0,1,2.343,0Z"
                              transform="translate(0.514 0.514)" fill="#31d1ab" />
                            <rect id="Rectangle-62-Copy-4" width="3.514" height="7.028" rx="1.5"
                              transform="translate(19.914 12.885)" fill="#d6c0b7" opacity="0.3" />
                          </g>
                        </svg>
                      </div>
                      <div class="txt">
                        <h3>Leverage our culture to grow more</h3>
                        <p>
                          We've built tools to help you keep a pulse on our culture and speak directly to what's relevent. 
                        </p>
                      </div>
    
                    </div>
                  </div>
    
                </div>
              </div>
            </section>
            <!-- End. serv_soft -->
    
            <!-- Start Easy Templates -->
            <section class="software_web margin-t-12" id="Products">
              <div class="container">
                <div class="row">
                  <div class="col-lg-5 my-auto order-1 order-lg-0">
                    <div class="item__section mb-4 mb-lg-0">
                      <div class="media">
                        <div class="icon_sec">
                          <svg xmlns="http://www.w3.org/2000/svg" width="11.711" height="24.599"
                            viewBox="0 0 11.711 24.599">
                            <g id="Group_6275" data-name="Group 6275" transform="translate(-8.202 -2.343)">
                              <path id="Path-17"
                                d="M14.614,6.686q-.286,4.016-1.959,5.271S13.442,4.343,11.186,2a19.579,19.579,0,0,1-2.092,8.367C8.113,12.132,7,13.88,7,16.224c0,3.347,4.062,4.518,5.86,4.518,2.106,0,5.851-1.171,5.851-5.271Q18.714,12.942,14.614,6.686Z"
                                transform="translate(1.2 0.343)" fill="#fff" fill-rule="evenodd" />
                              <path id="Rectangle-49"
                                d="M10.016,20h5.34a1.171,1.171,0,0,1,1.111.8l.9,2.713H8L8.9,20.8A1.171,1.171,0,0,1,10.016,20Z"
                                transform="translate(1.371 3.428)" fill="#fff" fill-rule="evenodd" opacity="0.3" />
                            </g>
                          </svg>
    
                        </div>
                        <div class="media-body">
                          <div class="title_sections mb-0">
                            <div class="before_title">
                              <span>Easy to use </span>
                              <span class="c-green2">Templates</span>
                            </div>
                            <h2>Get your business online fast with customizable templates</h2>
                            <p>
                              No coding required. Simply choose the template that matches your style, add your branding and products and start selling your stuff. 
                            </p>
                            <a href="{{route('company.create.index')}}" class="btn btn_lg_primary margin-t-2 sweep_top sweep_letter rounded-12 border-1">
                              <div class="inside_item">
                                <span data-hover="Yes, Free!">Start Free!</span>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7 order-0 order-lg-1 mb-4 mb-lg-0">
                    <div class="screen__ipad">
                      <img class="ipad_img" src="{{ asset('buynoir/superfront/assets/img/software/woman.jpeg')}}" alt="" data-aos="fade-up" data-aos-delay="0">
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <!-- End Easy Templates -->
              
            <!-- Start Easy Transfer Data -->
            <section class="software_web margin-t-12" id="Products">
              <div class="container">
                <div class="row">
                  <div class="col-lg-5 my-auto order-1 order-lg-0">
                    <div class="item__section mb-4 mb-lg-0">
                      <div class="media">
                        <div class="icon_sec">
                          <svg xmlns="http://www.w3.org/2000/svg" width="11.711" height="24.599"
                            viewBox="0 0 11.711 24.599">
                            <g id="Group_6275" data-name="Group 6275" transform="translate(-8.202 -2.343)">
                              <path id="Path-17"
                                d="M14.614,6.686q-.286,4.016-1.959,5.271S13.442,4.343,11.186,2a19.579,19.579,0,0,1-2.092,8.367C8.113,12.132,7,13.88,7,16.224c0,3.347,4.062,4.518,5.86,4.518,2.106,0,5.851-1.171,5.851-5.271Q18.714,12.942,14.614,6.686Z"
                                transform="translate(1.2 0.343)" fill="#fff" fill-rule="evenodd" />
                              <path id="Rectangle-49"
                                d="M10.016,20h5.34a1.171,1.171,0,0,1,1.111.8l.9,2.713H8L8.9,20.8A1.171,1.171,0,0,1,10.016,20Z"
                                transform="translate(1.371 3.428)" fill="#fff" fill-rule="evenodd" opacity="0.3" />
                            </g>
                          </svg>
    
                        </div>
                        <div class="media-body">
                          <div class="title_sections mb-0">
                            <div class="before_title">
                              <span>Easily transfer </span>
                              <span class="c-green2">your Data</span>
                            </div>
                            <h2>We make it easy for you to transition from one of those other Ecommerce Platforms</h2>
                            <p>
                              Take the leap and move to a platform made by black entrepenures for black entrepreneurs. We've made the features you need to grow your business with you in mind. We've also made it easy to move your stuff over from those other guys to BuyNoir.
                            </p>
                            <a href="{{route("company.create.index")}}" class="btn btn_lg_primary margin-t-2 sweep_top sweep_letter rounded-12 border-1">
                              <div class="inside_item">
                                <span data-hover="Yes, Free!">Start Free!</span>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7 order-0 order-lg-1 mb-4 mb-lg-0">
                    <div class="screen__ipad">
                      <img class="ipad_img" src="{{ asset('buynoir/superfront/assets/img/shop.jpeg')}}" alt="" data-aos="fade-up" data-aos-delay="0">
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <!-- End.Easy Templates -->
            
            <!-- Start software_web -->
            <section class="software_web margin-t-12" id="Products">
              <div class="container">
                <div class="row">
                  <div class="col-lg-5 my-auto order-1 order-lg-0">
                    <div class="item__section mb-4 mb-lg-0">
                      <div class="media">
                        <div class="icon_sec">
                          <svg xmlns="http://www.w3.org/2000/svg" width="11.711" height="24.599"
                            viewBox="0 0 11.711 24.599">
                            <g id="Group_6275" data-name="Group 6275" transform="translate(-8.202 -2.343)">
                              <path id="Path-17"
                                d="M14.614,6.686q-.286,4.016-1.959,5.271S13.442,4.343,11.186,2a19.579,19.579,0,0,1-2.092,8.367C8.113,12.132,7,13.88,7,16.224c0,3.347,4.062,4.518,5.86,4.518,2.106,0,5.851-1.171,5.851-5.271Q18.714,12.942,14.614,6.686Z"
                                transform="translate(1.2 0.343)" fill="#fff" fill-rule="evenodd" />
                              <path id="Rectangle-49"
                                d="M10.016,20h5.34a1.171,1.171,0,0,1,1.111.8l.9,2.713H8L8.9,20.8A1.171,1.171,0,0,1,10.016,20Z"
                                transform="translate(1.371 3.428)" fill="#fff" fill-rule="evenodd" opacity="0.3" />
                            </g>
                          </svg>
    
                        </div>
                        <div class="media-body">
                          <div class="title_sections mb-0">
                            <div class="before_title">
                              <span>You make it... </span>
                              <span class="c-green2">You keep it! $$$</span>
                            </div>
                            <h2>Keep 100% of the money you earn!</h2>
                            <p>
                              ok, maybe we should have led with this. That's right! You earn it, you keep it! BuyNoir takes none of your sales earnings. Simply pay a monthly fee to keep your shop running and you keep 100% of the money you earned. 
                            </p>
                            <a href="{{route("company.create.index")}}" class="btn btn_lg_primary margin-t-2 sweep_top sweep_letter rounded-12 border-1">
                              <div class="inside_item">
                                <span data-hover="Yes, Free!">Start Free!</span>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7 order-0 order-lg-1 mb-4 mb-lg-0">
                    <div class="screen__ipad">
                      <img class="ipad_img" src="{{ asset('buynoir/superfront/assets/img/bakery.jpeg')}}" alt="" data-aos="fade-up" data-aos-delay="0">
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <!-- End.software_web -->
    
            <!-- Start integration__logo -->
            <section class="integration__logo" id="Integrations">
              <div class="container">
                <div class="row justify-content-center text-center">
                  <div class="col-md-8 col-lg-5">
                    <div class="title_sections">
                      <div class="before_title">
                        <span class="c-green2">Integrations</span>
                      </div>
                      <h2>Seamless integration with marketing and sales tools</h2>
                      <p>Easily connect with the other tools that help keep your business grow. Integrate BuyNoir with your favorite marketing tools to level up your business.</p>
                      <a href="{{route("company.create.index")}}" class="btn btn_md_primary margin-t-2 bg-green2 c-white sweep_top sweep_letter rounded-12">
                        <div class="inside_item">
                          <span data-hover="Get Started">Get Started</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="block__circle">
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="0">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="200">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="300">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="400">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class=" item_logo" data-aos="fade-up" data-aos-delay="500">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                  <div class="item_logo" data-aos="fade-up" data-aos-delay="600">
                    <img src="{{ asset('buynoir/superfront/assets/img/software/logo/150.png')}}" alt="">
                  </div>
                </div>
              </div>
            </section>
            <!-- End. integration__logo -->
    
 
     
            <!-- Start Simple Contact -->
            <section class="simplecontact_section bg-white padding-py-12 z-index-3">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <div class="title_sections mb-1 mb-sm-auto">
                      <h2>Still not sure?</h2>
                      <p>
                        Reach out to us and ask us all your tough questions. 
                        <a class="c-green2" href="mailto:support@example.com">team@buynoir.co</a>.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 my-auto ml-auto text-sm-right">
                    <button type="button"
                      class="btn mt-3 rounded-12 sweep_top sweep_letter btn_md_primary c-white scale bg-green2">
                      <div class="inside_item">
                        <span data-hover="Contact Us">
                            <a href="{{route("buynoir.home.contactus")}}" alt="BuyNoir Contact Us">
                              Contact Us
                            </a>
                        </span>
                      </div>
                    </button>
                  </div>
                </div>
                <div class="circle-ripple z-index-0 d-none d-sm-block">
                  <div class="ripple ripple-1"></div>
                  <div class="ripple ripple-2"></div>
                  <div class="ripple ripple-3"></div>
                </div>
              </div>
            </section>
            <!-- End Simple Contact -->
          </main>
        </div>
        <!-- [id] content -->
    
     
      </div>
      <!-- End. wrapper -->
    

    {{ view_render_event('bagisto.saas.companies.home.content.after') }}

  
    
@endsection

 


