@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')

@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.search.page-title') }}
@endsection

@section('content-wrapper')
    <div class="container">
        <section class="search-container row">
            @if ($results && $results->count())
                <div class="filters-container col-12 mb-3">
                    @include ('shop::products.list.toolbar')
                </div>
            @endif

            @if (! $results)
                <h1 class="fw6 col-12">{{  __('shop::app.search.no-results') }}</h1>
            @else
                @if ($results->isEmpty())
                    <h1 class="fw6 col-12">{{ __('shop::app.products.whoops') }}</h1>
                    <span class="col-12">{{ __('shop::app.search.no-results') }}</span>
                @else

                    @foreach ($results as $productFlat)
                        @if ($toolbarHelper->getCurrentMode() == 'grid')
                            @include('shop::products.list.card', ['product' => $productFlat->product])
                        @else
                            @include('shop::products.list.card', [
                                'list' => true,
                                'product' => $productFlat->product
                            ])
                        @endif
                    @endforeach

                    <div class="mt-5 mb-5 col-12 search-pagination">
                        @include('ui::datagrid.pagination')
                    </div>
                @endif
            @endif
        </section>
    </div>
@endsection