@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.account.wishlist.page-title') }}
@endsection

@section('content-wrapper')
    @guest('customer')
        <div class="container">
            <wishlist-product></wishlist-product>
        </div>
    @endguest

    @auth('customer')
        @push('scripts')
            <script>
                window.location = '{{ route('customer.wishlist.index') }}';
            </script>
        @endpush
    @endauth
@endsection

@push('scripts')
    <script type="text/x-template" id="wishlist-product-template">
        <section class="cart-details wishlist-container no-margin col-12">
            <div class="d-flex mb-3 justify-content-between">
                <h1 class="text-uppercase t-l mb-0">
                    {{ __('shop::app.customer.account.wishlist.title') }}
                </h1>

                <div class="text-right" v-if="products.length > 0">
                    <button
                        class="btn btn-outline text-uppercase"
                        @click="removeProduct('all')">
                        {{ __('shop::app.customer.account.wishlist.deleteall') }}
                    </button>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.before') !!}

            <div class="row products-collection col-12 ml0">
                <shimmer-component v-if="!isProductListLoaded && !isMobile()"></shimmer-component>

                <template v-else-if="isProductListLoaded && products.length > 0">
                    <carousel-component
                        :slides-per-page="isMobile() ? 2 : 6"
                        navigation-enabled="hide"
                        pagination-enabled="hide"
                        id="wishlist-products-carousel"
                        :slides-count="products.length">

                        <slide
                            :key="index"
                            :slot="`slide-${index}`"
                            v-for="(product, index) in products">
                            <product-card :product="product"></product-card>
                        </slide>
                    </carousel-component>
                </template>

                <span v-else-if="isProductListLoaded">{{ __('customer::app.wishlist.empty') }}</span>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.guest-customer.view.after') !!}
        </section>
    </script>

    <script>
        Vue.component('wishlist-product', {
            template: '#wishlist-product-template',

            data: function () {
                return {
                    'products': [],
                    'isProductListLoaded': false,
                }
            },

            watch: {
                '$root.headerItemsCount': function () {
                    this.getProducts();
                }
            },

            mounted: function () {
                this.getProducts();
            },

            methods: {
                'getProducts': function () {
                    let items = this.getStorageValue('wishlist_product');
                    items = items ? items.join('&') : '';

                    if (items != "") {
                        this.$http
                        .get(`${this.$root.baseUrl}/detailed-products`, {
                            params: { moveToCart: true, items }
                        })
                        .then(response => {
                            this.isProductListLoaded = true;
                            this.products = response.data.products;
                        })
                        .catch(error => {
                            this.isProductListLoaded = true;
                            console.log(this.__('error.something_went_wrong'));
                        });
                    } else {
                        this.products = [];
                        this.isProductListLoaded = true;
                    }
                },

                'removeProduct': function (productId) {
                    let existingItems = this.getStorageValue('wishlist_product');

                    if (productId == "all") {
                        updatedItems = [];
                        this.$set(this, 'products', []);
                    } else {
                        updatedItems = existingItems.filter(item => item != productId);
                        this.$set(this, 'products', this.products.filter(product => product.slug != productId));
                    }

                    this.$root.headerItemsCount++;
                    this.setStorageValue('wishlist_product', updatedItems);
					
                    window.showAlert(
                        `alert-success`,
                        this.__('shop.general.alert.success'),
                        `${this.__('customer.wishlist.remove-all-success')}`
                    );
					
					this.$root.$emit('wishlistEvent', updatedItems);
                }
            }
        });
    </script>
@endpush