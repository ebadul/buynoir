@extends('shop::layouts.master')

@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('customHelper', 'Webkul\Velocity\Helpers\Helper')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $total = $reviewHelper->getTotalReviews($product);
    $customAttributeValues = $productViewHelper->getAdditionalData($product);
    $attributeMap = [];
    foreach ($customAttributeValues as $value) {
        $attributeMap[$value['code']] = $value;
    }

    $avgRatings = $reviewHelper->getAverageRating($product);
    $avgStarRating = ceil($avgRatings);

    $productImages = [];
    $images = $productImageHelper->getGalleryImages($product);

    foreach ($images as $key => $image) {
        array_push($productImages, $image['medium_image_url']);
    }
@endphp

@section('page_title')
    {{ trim($product->meta_title) != "" ? $product->meta_title : $product->name }}
@stop

@section('seo')
    <meta name="description" content="{{ trim($product->meta_description) != "" ? $product->meta_description : \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}"/>
    <meta name="keywords" content="{{ $product->meta_keywords }}"/>
@stop

@push('css')
    <style type="text/css">
        .related-products {
            width: 100%;
        }

        .recently-viewed {
            margin-top: 20px;
        }

        .store-meta-images > .recently-viewed:first-child {
            margin-top: 0px;
        }

        .main-content-wrapper {
            margin-bottom: 0px;
        }
    </style>
@endpush

@section('full-content-wrapper')
    {!! view_render_event('bagisto.shop.products.view.before', ['product' => $product]) !!}
        <div class="container px-0">
            <div class="row no-margin">
                <section class="col-12 product-detail">
                    <div class="layouter">
                        <div class="row mx-0" v-if="isMobile()">
                            <div class="col-lg-6 px-3" >
                                @include ('shop::products.view.gallery')
                            </div>
                            <div class="w-100 px-3 pt-3">
                                <p class="text-muted text-center">Product code: {{ $product->sku }}</p>
                            </div>
                        </div>
                        <product-view>
                            <div class="form-container row mx-0">
                                @csrf()

                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                                {{-- product-gallery --}}
                                <div class="col-lg-6 px-3" v-if="!isMobile()">
                                    @include ('shop::products.view.gallery')
                                </div>

                                {{-- right-section --}}
                                <div class="col-lg-6 px-3">
                                    {{-- product-info-section --}}
                                    <div class="product-info">
                                        <div class="info">
                                            @if (array_key_exists('brand', $attributeMap) && $attributeMap['brand']['value'])
                                                <h2 class="product-brand mb-3">{{ $attributeMap['brand']['value'] }}</h2>
                                            @endif
                                            <h2 class="product-name mb-4">{{ $product->name }}</h2>

                                            @include ('shop::products.view.stock', ['product' => $product])

                                            <div class="price mb-4">
                                                @include ('shop::products.price', ['product' => $product])
                                            </div>
                                            

                                            <div v-if="!isMobile()">
                                                @include ('shop::products.view.configurable-options')
                                                
                                                <div class="product-actions mb-3 align-items-center d-flex">
                                                    {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                                                    @if ($product->getTypeInstance()->showQuantityBox())
                                                        <div class="mr-3">
                                                            <quantity-changer></quantity-changer>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="quantity" value="1">
                                                    @endif

                                                    {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}
                                                    @include ('shop::products.add-to-cart', [
                                                        '' => false,
                                                        'product' => $product,
                                                        'showCompare' => false,
                                                        'showCartIcon' => false,
                                                    ])
                                                </div>
                                            </div>
                                        </div>

                                        @include ('shop::products.view.downloadable')

                                        @include ('shop::products.view.grouped-products')

                                        @include ('shop::products.view.bundle-options')

                                        {{-- product long description --}}
                                        @include ('shop::products.view.description')

                                        <div class="mobile-add-to-cart" v-if="isMobile()">
                                            @include ('shop::products.view.configurable-options')
                                            
                                            <div class="product-actions justify-content-center mb-1 align-items-center d-flex">
                                                {!! view_render_event('bagisto.shop.products.view.quantity.before', ['product' => $product]) !!}

                                                @if ($product->getTypeInstance()->showQuantityBox())
                                                    <div class="mr-3">
                                                        <quantity-changer></quantity-changer>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="quantity" value="1">
                                                @endif

                                                {!! view_render_event('bagisto.shop.products.view.quantity.after', ['product' => $product]) !!}
                                                @include ('shop::products.add-to-cart', [
                                                    '' => false,
                                                    'product' => $product,
                                                    'showCompare' => false,
                                                    'showCartIcon' => false,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </product-view>
                    </div>
                </section>

                <div class="related-products">
                    @include('shop::products.view.related-products')
                    @include('shop::products.view.up-sells')
                </div>

                <div class="store-meta-images col-3">
                    @if(
                        isset($ultimaMetaData['product_view_images'])
                        && $ultimaMetaData['product_view_images']
                    )
                        @foreach (json_decode($ultimaMetaData['product_view_images'], true) as $image)
                            @if ($image && $image !== '')
                                <img src="{{ url()->to('/') }}/storage/{{ $image }}" />
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    {!! view_render_event('bagisto.shop.products.view.after', ['product' => $product]) !!}
@endsection

@push('scripts')
    <script type='text/javascript' src='https://unpkg.com/spritespin@4.1.0/release/spritespin.js'></script>

    <script type="text/x-template" id="product-view-template">
        <form
            method="POST"
            id="product-form"
            @click="onSubmit($event)"
            action="{{ route('cart.add', $product->product_id) }}">

            <input type="hidden" name="is_buy_now" v-model="is_buy_now">

            <slot v-if="slot"></slot>

            <div v-else>
                <div class="spritespin"></div>
            </div>

        </form>
    </script>

    <script>
        Vue.component('product-view', {
            inject: ['$validator'],
            template: '#product-view-template',
            data: function () {
                return {
                    slot: true,
                    is_buy_now: 0,
                }
            },

            mounted: function () {
                // this.open360View();
                let currentProductId = '{{ $product->url_key }}';
                let existingViewed = window.localStorage.getItem('recentlyViewed');

                if (! existingViewed) {
                    existingViewed = [];
                } else {
                    existingViewed = JSON.parse(existingViewed);
                }

                if (existingViewed.indexOf(currentProductId) == -1) {
                    existingViewed.push(currentProductId);

                    if (existingViewed.length > 3)
                        existingViewed = existingViewed.slice(Math.max(existingViewed.length - 4, 1));

                    window.localStorage.setItem('recentlyViewed', JSON.stringify(existingViewed));
                } else {
                    var uniqueNames = [];

                    $.each(existingViewed, function(i, el){
                        if ($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                    });

                    uniqueNames.push(currentProductId);

                    uniqueNames.splice(uniqueNames.indexOf(currentProductId), 1);

                    window.localStorage.setItem('recentlyViewed', JSON.stringify(uniqueNames));
                }
            },

            methods: {
                onSubmit: function(event) {
                    if (event.target.getAttribute('type') != 'submit')
                        return;

                    event.preventDefault();

                    this.$validator.validateAll().then(result => {
                        if (result) {
                            this.is_buy_now = event.target.classList.contains('buynow') ? 1 : 0;

                            setTimeout(function() {
                                document.getElementById('product-form').submit();
                            }, 0);
                        }
                    });
                },

                open360View: function () {
                    this.slot = false;

                    setTimeout(() => {
                        $('.spritespin').spritespin({
                            source: SpriteSpin.sourceArray('http://shubham.webkul.com/3d-image/sample-{lane}-{frame}.jpg', {
                                lane: [0,5],
                                frame: [0,5],
                                digits: 2
                            }),
                            // width and height of the display
                            width: 400,
                            height: 225,
                            // the number of lanes (vertical angles)
                            lanes: 12,
                            // the number of frames per lane (per vertical angle)
                            frames: 24,
                            // interaction sensitivity (and direction) modifier for horizontal movement
                            sense: 1,
                            // interaction sensitivity (and direction) modifier for vertical movement
                            senseLane: -2,

                            // the initial lane number
                            lane: 6,
                            // the initial frame number (within the lane)
                            frame: 0,
                            // disable autostart of the animation
                            animate: false,

                            plugins: [
                                'progress',
                                '360',
                                'drag'
                            ]
                        });
                    }, 0);
                }
            }
        });

        window.onload = function() {
            var thumbList = document.getElementsByClassName('thumb-list')[0];
            var thumbFrame = document.getElementsByClassName('thumb-frame');
            var productHeroImage = document.getElementsByClassName('product-hero-image')[0];

            if (thumbList && productHeroImage) {
                for (let i=0; i < thumbFrame.length ; i++) {
                    thumbFrame[i].style.height = (productHeroImage.offsetHeight/4) + "px";
                    thumbFrame[i].style.width = (productHeroImage.offsetHeight/4)+ "px";
                }

                if (screen.width > 720) {
                    thumbList.style.width = (productHeroImage.offsetHeight/4) + "px";
                    thumbList.style.minWidth = (productHeroImage.offsetHeight/4) + "px";
                    thumbList.style.height = productHeroImage.offsetHeight + "px";
                }
            }

            window.onresize = function() {
                if (thumbList && productHeroImage) {

                    for(let i=0; i < thumbFrame.length; i++) {
                        thumbFrame[i].style.height = (productHeroImage.offsetHeight/4) + "px";
                        thumbFrame[i].style.width = (productHeroImage.offsetHeight/4)+ "px";
                    }

                    if (screen.width > 720) {
                        thumbList.style.width = (productHeroImage.offsetHeight/4) + "px";
                        thumbList.style.minWidth = (productHeroImage.offsetHeight/4) + "px";
                        thumbList.style.height = productHeroImage.offsetHeight + "px";
                    }
                }
            }
        };
    </script>
@endpush