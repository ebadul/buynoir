@extends('shop::layouts.master')

@section('page_title')
    {{ $page->page_title }}
@endsection

@section('head')
    @isset($page->meta_title)
        <meta name="title" content="{{ $page->meta_title }}" />
    @endisset

    @isset($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}" />
    @endisset

    @isset($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
    @endisset
@endsection

@php
    $page_name = last(explode("/", $_SERVER['REQUEST_URI']));
@endphp

@section('content-wrapper')
    @if ($page_name == 'contact-us' || $page_name == 'contact')
        <div id="contact-page">
            <div class="container">                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success text-center">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-6">
                        {!! DbView::make($page)->field('html_content')->render() !!}
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h1 class="t-l text-uppercase">{{ __('Send us an email') }}</h1>
                            <p class="text-center text-uppercase">{{ __('We are here to help') }}</p>
                        </div>
                        <form method="post" action="{{ url('contact') }}">
                            @csrf
                            <div class="form-group">
                                <label for="first_name" class="mandatory label-style text-uppercase">
                                    {{ __('First Name') }}
                                </label>
                                <input type="text" name="first_name" value="" class="form-style w-100">
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="mandatory label-style text-uppercase">
                                    {{ __('Last Name') }}
                                </label>
                                <input type="text" name="last_name" value="" class="form-style w-100">
                            </div>
                            <div class="form-group">
                                <label for="email" class="mandatory label-style text-uppercase">
                                    {{ __('Email') }}
                                </label>
                                <input type="text" name="email" value="" class="form-style w-100">
                            </div>
                            <div class="form-group mb-4">
                                <label for="message" class="mandatory label-style text-uppercase">
                                    {{ __('Your message') }}
                                </label>
                                <textarea name="message" class="form-style w-100"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn text-uppercase">{{ __('Send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container generic-page-container">
            <div class="cms-page-container">
                
            </div>
        </div>
    @endif
@endsection