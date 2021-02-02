@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

@php
    $images = $productImageHelper->getGalleryImages($product);
@endphp

{!! view_render_event('bagisto.shop.products.view.gallery.before', ['product' => $product]) !!}

    <div class="product-image-group mx-0 row">
        <div class="col-lg-3 col-12 pl-0 pr-0 pr-lg-3" :class="{'product-thumbs-desk': !isMobile()}">
            <product-gallery></product-gallery>
        </div>
        <div class="col-lg-9 main-product-image" v-if="!isMobile()">
            <magnify-image src="{{ $images[0]['large_image_url'] }}" >
            </magnify-image>

            <img
                class="vc-small-product-image"
                src="{{ $images[0]['large_image_url'] }}" />
            @if (! (isset($showWishlist) && !$showWishlist))
                @include('shop::products.wishlist', [
                    'addClass' => $addWishlistClass ?? ''
                ])
            @endif
            <div>
                <p class="pt-2 text-muted text-right">Product code: {{ $product->sku }}</p>
            </div>
        </div>
    </div>

{!! view_render_event('bagisto.shop.products.view.gallery.after', ['product' => $product]) !!}

<script type="text/x-template" id="product-gallery-template">
    <div class="w-100">
        <vertical-slider
            v-if="!isMobile()"
            :items-to-show="3"
            :slides-count="thumbs.length">
            <div
                :slot="`slide-${index}`"
                v-for="(thumb, index) in thumbs"
                @click="changeImage({
                    largeImageUrl: thumb.large_image_url,
                    originalImageUrl: thumb.original_image_url,
                })"
                :class="`thumb-frame ${thumb.large_image_url == currentLargeImageUrl ? 'active' : ''}`"
                >

                <div
                    class="bg-image"
                    :style="`background-image: url(${thumb.small_image_url})`">
                </div>
            </div>
        </vertical-slider>
        <div class="mobile-gallery w-100" type="none" v-else>
            <carousel-component
                slides-per-page="1"
                add-class="product-gallery"
                :slides-count="thumbs.length">
                <slide :slot="`slide-${index}`" v-for="(thumb, index) in thumbs">
                    <img :src="thumb.large_image_url" />
                </slide>
            </carousel-component>
        </div>
    </div>
</script>

@push('scripts')
    <script type="text/javascript">
        (() => {
            var galleryImages = @json($images);

            Vue.component('product-gallery', {
                template: '#product-gallery-template',
                data: function() {
                    return {
                        images: galleryImages,
                        thumbs: [],
                        galleryCarouselId: 'product-gallery-carousel',
                        currentLargeImageUrl: '',
                        currentOriginalImageUrl: '',
                        counter: {
                            up: 0,
                            down: 0,
                        }
                    }
                },

                watch: {
                    'images': function(newVal, oldVal) {
                        this.changeImage({
                            largeImageUrl: this.images[0]['large_image_url'],
                            originalImageUrl: this.images[0]['original_image_url'],
                        })

                        this.prepareThumbs()
                    }
                },

                created: function() {
                    this.changeImage({
                        largeImageUrl: this.images[0]['large_image_url'],
                        originalImageUrl: this.images[0]['original_image_url'],
                    });

                    eventBus.$on('configurable-variant-update-images-event', this.updateImages);

                    this.prepareThumbs()
                },

                mounted() {
                    // Avoids form submission on button click
                    $('.VueCarousel-dot').on('click', function(event) {
                        console.log(event);
                        event.preventDefault();
                    });
                },

                methods: {
                    updateImages: function (galleryImages) {
                        this.images = galleryImages;
                    },

                    prepareThumbs: function() {
                        this.thumbs = [];

                        this.images.forEach(image => {
                            this.thumbs.push(image);
                        });
                    },

                    changeImage: function({largeImageUrl, originalImageUrl}) {
                        this.currentLargeImageUrl = largeImageUrl;

                        this.currentOriginalImageUrl = originalImageUrl;

                        this.$root.$emit('changeMagnifiedImage', {
                            smallImageUrl: this.currentOriginalImageUrl
                        });

                        let productImage = $('.vc-small-product-image');
                        if (productImage && productImage[0]) {
                            productImage = productImage[0];

                            productImage.src = this.currentOriginalImageUrl;
                        }
                    },

                    scroll: function (navigateTo) {
                        let navigation = $(`#${this.galleryCarouselId} .VueCarousel-navigation .VueCarousel-navigation-${navigateTo}`);

                        if (navigation && (navigation = navigation[0])) {
                            navigation.click();
                        }
                    },
                }
            });
        })()
    </script>
@endpush