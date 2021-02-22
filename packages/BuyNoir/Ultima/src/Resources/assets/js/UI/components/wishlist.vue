<template>
    <i
        v-if="isCustomer == 'true'"
        :class="{'ei-icon_heart': !isActive, 'ei-icon_heart_alt': isActive}"
        @mouseover="isActive ? isActive = !isActive : ''"
        @mouseout="active !== '' && !isActive ? isActive = !isActive : ''"></i>

    <a
        v-else
        @click="toggleProductWishlist(productId)"
        :class="`unset wishlist-icon ${addClass ? addClass : ''}`">

        <i
            @mouseout="! isStateChanged ? isActive = !isActive : isStateChanged = false"
            @mouseover="! isStateChanged ? isActive = !isActive : isStateChanged = false"
            :class="{'ei-icon_heart': isActive, 'ei-icon_heart_alt': !isActive}"></i>

        <span style="vertical-align: super;" v-html="text"></span>
    </a>
</template>

<script type="text/javascript">
    export default {
        props: [
            'text',
            'active',
            'addClass',
            'addedText',
            'productId',
            'removeText',
            'isCustomer',
            'productSlug',
            'moveToWishlist',
        ],

        data: function () {
            return {
                isStateChanged: false,
                isActive: this.active,
            }
        },

        created: function () {
            if (this.isCustomer == 'false') {
                this.isActive = this.isWishlisted(this.productId);
            }
        },

        methods: {
            toggleProductWishlist: function (productId) {
                var updatedValue = [productId];
                let existingValue = this.getStorageValue('wishlist_product');

                if (existingValue) {
                    var valueIndex = existingValue.indexOf(productId);

                    if (valueIndex == -1) {
                        this.isActive = true;
                        existingValue.push(productId);
                    } else {
                        this.isActive = false;
                        existingValue.splice(valueIndex, 1);
                    }

                    updatedValue = existingValue;
                }

                this.$root.headerItemsCount++;
                this.isStateChanged = true;

                this.setStorageValue('wishlist_product', updatedValue);
				this.buttonClicked(updatedValue);
                window.showAlert(
                    'alert-success',
                    this.__('shop.general.alert.success'),
                    this.isActive ? this.addedText : this.removeText
                );

                if (this.moveToWishlist && valueIndex == -1) {
                    window.location.href = this.moveToWishlist;
                }

                return true;
            },

            isWishlisted: function (productId) {
                let existingValue = this.getStorageValue('wishlist_product');

                if (existingValue) {
                    return ! (existingValue.indexOf(productId) == -1);
                } else {
                    return false;
                }
            },
			
			buttonClicked: function (updatedValue) {
			  this.$root.$emit('wishlistEvent', updatedValue);			 
			}
			
        }
    }
</script>