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
        <div id="content" id="buynoir-homepage">
       
    
          <!-- Stat main -->
          <main data-spy="scroll" data-target="#navbar-example2" data-offset="0">
         
    
            <!-- Start integration__logo -->
            <section class=" hidden mt-5" id="Integrations">
              <div class="container mt-5">
                <div class="row justify-content-center text-center ">
                  <div class="col-md-12 col-lg-8 mt-5">
                    <div class="title_sections mt-5">
                      <div class="before_title">
                        <span class="c-green2">Contact us</span>
                      </div>
                      <h2>Seamless integration with marketing and sales tools</h2>
                      <p>Easily connect with the other tools that help keep your business grow. Integrate BuyNoir with your favorite marketing tools to level up your business.</p>

                     
                                         
                    </div>
                  </div>
                </div>
                
              </div>
            </section>
            <!-- End. integration__logo -->
    
 
     
         
          </main>
        </div>
        <!-- [id] content -->
    
     
      </div>
      <!-- End. wrapper -->
    

    {{ view_render_event('bagisto.saas.companies.home.content.after') }}

  
    
@endsection

 


