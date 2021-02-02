@extends('shop::layouts.master')

@section('page_title')
    {{ __('admin::app.error.404.page-title') }}
@stop

@section('body-header')
@endsection

@section('full-content-wrapper')
    <div class="error-page row justify-content-center">
        <div class="col-md-6 border">
            <div class="text-center">
                @if ($logo = core()->getCurrentChannel()->logo_url)
                    <div
                        class="col-12 velocity-icon bg-image"
                        style="background-image: url('{{ $logo }}')"
                    ></div>
                @else
                    <img src="public/themes/ultima/assets/images/ultima.png"/>
                @endif
            </div>
            <h1 class="t-l text-center">404 - Page not found</h1>
            <p class="text-center">
                {{ __('velocity::app.error.page-lost-description') }}
            </p>
            <div class="text-center pb-3">
                <a class="btn" href="{{ route('shop.home.index') }}">
                    <span class="">
                        {{ __('velocity::app.error.go-to-home') }}
                    </span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@show
