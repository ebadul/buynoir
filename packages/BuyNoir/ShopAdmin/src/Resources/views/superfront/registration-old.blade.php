@extends('landingpage_view::landingpage.layouts.master')

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
            <section class="section_account">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6 col-lg-4">
                      <div class="fixed_side_data">
                        <div class="head_nav">
                          <a href="{{route('buynoir.home.index')}}" class="btn btn_logo">
                            <!-- <img src="assets/img/logo.svg" /> -->
                            BuyNoir<span class="c-blue">.</span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-5 mx-auto">
                      <div class="have_account">
                        Already a member?
                        <button type="button" class="btn" data-toggle="modal" data-target="#mdllLogin">
                          Sign in
                        </button>
                      </div>
        
                      <div class="box--signup">
                        <div class="title">
                          Sign up now.
                        </div>
                        <div class="other_login">
                          <button type="button" class="btn scale btn-loin-google">
                            <i class="tio google"></i>
                            Sign up with Google
                          </button>
                          <button type="button" class="btn scale btn_twitter">
                            <i class="tio twitter"></i>
                          </button>
                          <div class="line-or">
                            <span class="or">or</span>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Full name</label>
                                  <input type="text" class="form-control" placeholder="Full Name" />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Username</label>
                                  <input type="text" class="form-control" placeholder="Username" />
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Email address</label>
                                  <input type="email" class="form-control" placeholder="Email Address" />
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group --password" id="show_hide_password">
                                  <label>Password</label>
                                  <div class="input-group">
                                    <input type="password" class="form-control" data-toggle="password"
                                    required="" />
                                    <div class="input-group-prepend hide_show">
                                      <a href=""><span class="input-group-text tio hidden_outlined"></span></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 terms">
                                <p>
                                  By clicking on the Sign Up button, you agree to
                                  Rakon.
                                  <a href="#">terms and conditions of use.</a>
                                </p>
                              </div>
                              <div class="col-12">
                                <a href="" class="btn mt-3 rounded-6 btn_md_primary c-white effect-letter bg-blue">
                                  Create account</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
        </div><!-- end content -->
    </div><!-- end wrapper -->
    

    {{ view_render_event('bagisto.saas.companies.home.content.after') }}

@endsection




