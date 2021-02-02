<template>
    <hooper
        :itemsToShow="showItemsCount"
        :trimWhiteSpace="true"
        :vertical="true">
        <hooper-slide v-for="index in parseInt(slidesCount)" :key="index">
            <slot
                :name="`slide-${parseInt(index) - 1}`">
            </slot>
        </hooper-slide>
        <hooper-navigation slot="hooper-addons" v-show="slidesCount > itemsToShow"></hooper-navigation>
    </hooper>
</template>

<script>
    import { Hooper, Slide as HooperSlide, Navigation as HooperNavigation } from 'hooper';
    export default {
        props: {
            itemsToShow: Number,
            slidesCount: Number
        },
        computed: {
            showItemsCount() {
                return this.slidesCount > this.itemsToShow ? this.itemsToShow : this.slidesCount;
            }
        },
        components: {
            Hooper,
            HooperSlide,
            HooperNavigation
        }
    }
</script>