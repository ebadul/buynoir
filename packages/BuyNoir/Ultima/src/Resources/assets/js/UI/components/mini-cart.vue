<template>
    <div :class="`dropdown ${cartItems.length > 0 ? '' : 'disable-active'}`">
        <cart-btn @open-cart="openCart" :item-count="cartItems.length"></cart-btn>
        <div
            id="cart-modal-content"
            class="cart-modal"
            v-show="isCartOpen">

            <div v-if="cartItems.length > 0">
                <!--Body-->
                <div class="mini-cart-container">
                    <div class="row small-card-container py-3" :key="index" v-for="(item, index) in cartItems">
                        <div class="col-3 product-image-container mr15">
                            <a @click="removeProduct(item.id)">
                                <span class="rango-close"></span>
                            </a>

                            <a class="unset" :href="`${$root.baseUrl}/${item.url_key}`">
                                <div
                                    class="product-image"
                                    :style="`background-image: url(${item.images.medium_image_url});`">
                                </div>
                            </a>
                        </div>
                        <div class="col-9 no-padding card-body align-vertical-top">
                            <div class="no-padding">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="fs16 text-nowrap fw6" v-html="item.name"></div>
                                    <strong class="card-total-price fw6">
                                        {{ item.base_total }}
                                    </strong>
                                </div>

                                <div class="fs18 card-current-price text-left">
                                    <div class="d-flex justify-content-between">
                                        <label class="text-nowrap">{{ __('checkout.qty') }}</label>
                                        <span>{{ item.quantity }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer py-3 d-flex justify-content-between">
                    <h2 class="text-left subtotal-text">
                        {{ subtotalText }}
                    </h2>

                    <h2 class="text-right no-padding subtotal-price">{{ cartInformation.base_sub_total }}</h2>
                </div>

                <div class="modal-footer py-3 d-flex justify-content-between">
                    <a class="col btn btn-outline" :href="viewCart">{{ cartText }}</a>

                    <div class="col text-right no-padding">
                        <a :href="checkoutUrl">
                            <button
                                type="button"
                                class="theme-btn fs16 fw6">
                                {{ checkoutText }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div v-else>
                {{ emptyCartText }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'cartText',
            'viewCart',
            'checkoutUrl',
            'checkoutText',
            'subtotalText',
            'emptyCartText'
        ],

        data: function () {
            return {
                cartItems: [],
                cartInformation: [],
                isCartOpen: false
            }
        },

        mounted: function () {
            this.getMiniCartDetails();
        },

        watch: {
            '$root.miniCartKey': function () {
                this.getMiniCartDetails();
            }
        },

        methods: {
            getMiniCartDetails: function () {
                this.$http.get(`${this.$root.baseUrl}/mini-cart`)
                .then(response => {
                    if (response.data.status) {
                        this.cartItems = response.data.mini_cart.cart_items;
                        this.cartInformation = response.data.mini_cart.cart_details;
                    }
                })
                .catch(exception => {
                    console.log(this.__('error.something_went_wrong'));
                });
            },
            openCart() {
                this.isCartOpen = !this.isCartOpen;
            },
            removeProduct: function (productId) {
                this.$http.delete(`${this.$root.baseUrl}/cart/remove/${productId}`)
                .then(response => {
                    this.cartItems = this.cartItems.filter(item => item.id != productId);

                    window.showAlert(`alert-${response.data.status}`, response.data.label, response.data.message);
                })
                .catch(exception => {
                    console.log(this.__('error.something_went_wrong'));
                });
            }
        }
    }
</script>
