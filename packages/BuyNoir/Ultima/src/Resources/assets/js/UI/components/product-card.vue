<template>
    <div class="card grid-card product-card-new">
        <a :href="`${baseUrl}/${product.slug}`" :title="product.name" class="product-image-container">
            <img
                loading="lazy"
                :alt="product.name"
                :src="preferredImage"
                :data-src="preferredImage"
                class="card-img-top lzy_img"
                :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />
        </a>

        <div class="card-body">
            <div class="product-name">
                <a
                    class="unset"
                    :title="product.name"
                    :href="`${baseUrl}/${product.slug}`">

                    <span class="product-name-title">{{ product.name }}</span>
                </a>
            </div>

            <div class="product-price" v-html="product.priceHTML"></div>

            <div
                class="product-rating no-padding"
                v-if="product.totalReviews && product.totalReviews > 0">

                <star-ratings :ratings="product.avgRating"></star-ratings>
                <a class="fs14 align-top unset active-hover" :href="`${$root.baseUrl}/reviews/${product.slug}`">
                    {{ __('products.reviews-count', {'totalReviews': product.totalReviews}) }}
                </a>
            </div>

            <div class="product-rating col-12 no-padding" v-else>
                <span class="fs14" v-text="product.firstReviewText"></span>
            </div>

            <vnode-injector :nodes="getDynamicHTML(product.addToCartHtml)"></vnode-injector>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: [
            'list',
            'product',
        ],

        computed: {
            preferredImage() {
                return this.product.galleryImages[0].large_image_url;
            }
        },

        data: function () {
            return {
                'addToCart': 0,
                'addToCartHtml': '',
            }
        },
    }
</script>