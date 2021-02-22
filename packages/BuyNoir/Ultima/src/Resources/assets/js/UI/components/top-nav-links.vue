<template>
    <div class="top-links">
        <ul class="nav d-flex justify-content-end">
            <li class="nav-item text-center">
                <a class="nav-link" href="#" @click.prevent="toggleSearch">
                    <i class="nav-link-image ei-icon_search"></i>
                    <span>Search</span>
                </a>
            </li>
            <li
                class="nav-item text-center sign-in-show-on-hover"
                :class="{ 'must-show': isSignInActive }"
                @click="toggleSignIn"
            >
                <a class="nav-link" href="#" @click.prevent>
                    <i class="nav-link-image ei-icon_profile"></i>
                    <span v-if="!isLoggedIn">Sign In</span>
                    <span v-else>My Account</span>
                </a>
                <slot name="login"></slot>
            </li>
                    
			<li class="nav-item text-center">
                <a
                    class="nav-link"
                    :href="
                        isLoggedIn
                            ? `${$root.baseUrl}/customer/account/wishlist`
                            : `${$root.baseUrl}/guest-wishlist`
                    "
                >
                    <i class="nav-link-image ei-heart_alt"></i>
                    <span>Wishlist</span>
                    <span class="number-bubble" v-if="numWishlisted">
						{{ numWishlisted }}
					</span>
                </a>
            </li>
            <li class="nav-item text-center position-relative">
                <slot name="minicart"></slot>
            </li>
        </ul>
        <div class="search" v-show="isSearchActive">
            <searchbar-component
                @close-search="closeSearch"
            ></searchbar-component>
        </div>
    </div>
</template>

<script>
    import lodash from "lodash";
    export default {
        props: {
            isLoggedIn: {
                type: Boolean
            }
        },
        data() {
            return {
                isSearchActive: false,
                isSignInActive: false,
                numWishlisted: 0
            };
        },
        mounted(){
			 
            this.numWishlisted = this.getStorageValue("wishlist_product")
                ? this.getStorageValue("wishlist_product").length
                : 0;
			 
				this.$root.$on('wishlistEvent', (wishlists) => { 
				  this.numWishlisted = this.getStorageValue("wishlist_product")
					? this.getStorageValue("wishlist_product").length
					: 0;
				});
				
        },
        methods: {
            closeSearch() {
                this.isSearchActive = false;
            },
            toggleSearch() {
                this.isSearchActive = !this.isSearchActive;
                this.$nextTick(function() {
                    document.getElementById("search-box").focus();
                });
            },
            toggleSignIn() {
                this.isSignInActive = !this.isSignInActive;
            }
        }
    };
</script>
