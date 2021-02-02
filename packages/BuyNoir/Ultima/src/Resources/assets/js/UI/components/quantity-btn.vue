<template>

    <div class="qty-btn unselectable">
        <div class="deduct-btn" @click="count--">
            <i class="ei-icon_minus-06"></i>
        </div>
        <div class="actual-count">{{ count }}</div>
        <div class="increase-btn" @click="count++">
            <i class="ei-icon_plus"></i>
        </div>
    </div>

</template>

<script type="text/javascript">
    export default {
        data: function () {
            return {
                count: 1,
            }
        },

        watch: {
            count: function (newValue, oldValue) {
                this.count = newValue < 1 ? oldValue : newValue;
            }
        }
    }
</script>