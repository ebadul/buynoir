<template>
    <div class="brand-slider overflow-hidden mb-section">
        <h3 class="mb-5">{{ brandsText }}</h3>
        <carousel-component
            :slides-per-page="isMobile() ? 2 : 5"
            pagination-enabled="hide"
            id="brands-carousel"
            :slides-count="brands.length">

            <slide
                :key="index"
                :slot="`slide-${index}`"
                v-for="(brand, index) in brands">
                <div>
                    <img :src="brand.image_url" class="brand-logo mw-100" />
                </div>
            </slide>
        </carousel-component>
    </div>
</template>

<script>
    export default {
        props: ['brands', 'brandsText']
    }
</script>