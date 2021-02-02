<script type="text/x-template" id="cart-btn-template">
    <a
        href="#"
        id="mini-cart"
        class="nav-link"
        @click.prevent="toggleMiniCart">

        <div class="mini-cart-content">
            <i class="nav-link-image d-block ei-bag_alt"></i>
            <span class="number-bubble" v-text="itemCount" v-if="itemCount != 0"></span>
            <span class="cart-text">{{ __('Shopping Bag') }}</span>
        </div>
    </a>
</script>

<script type="text/x-template" id="close-btn-template">
    <button type="button" class="close disable-box-shadow">
        <span class="white-text fs20" @click="togglePopup">×</span>
    </button>
</script>

<script type="text/x-template" id="quantity-changer-template">
    <div :class="`quantity control-group ${errors.has(controlName) ? 'has-error' : ''}`">
        <div>
            <label class="required">{{ __('shop::app.products.quantity') }}</label>
        </div>
        <div>
            <button type="button" class="decrease" @click="decreaseQty()">
                <i class="ei-icon_minus-06"></i>
            </button>
            <input
                :value="qty"
                class="control"
                :name="controlName"
                :v-validate="validations"
                data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;"
                readonly />

            <button type="button" class="increase" @click="increaseQty()">
                <i class="ei-icon_plus"></i>
            </button>
        </div>

        <span class="control-error" v-if="errors.has(controlName)">@{{ errors.first(controlName) }}</span>
    </div>
</script>

@include('velocity::UI.header')

<script type="text/x-template" id="logo-template">
    <a
        :class="`left ${addClass} logo-wrapper`"
        href="{{ route('shop.home.index') }}">

        @if ($logo = core()->getCurrentChannel()->logo_url)
            <img class="logo" src="{{ $logo }}" />
        @else
            <img class="logo" src="{{ asset('themes/ultima/assets/images/ultima.png') }}" />
        @endif
    </a>
</script>

<script type="text/x-template" id="searchbar-template">
    <div class="row no-margin right searchbar w-100">
        <div class="col-lg-12 col-md-12 no-padding input-group">
            <form
                method="GET"
                role="search"
                id="search-form"
                class="w-100"
                action="{{ route('velocity.search.index') }}">

                <div
                    class="btn-toolbar w-100"
                    role="toolbar">

                    <div class="btn-group w-100">
                        <div class="selectdiv">
                            <select class="form-control fs13 styled-select" name="category" @change="focusInput($event)">
                                <option value="">
                                    {{ __('velocity::app.header.all-categories') }}
                                </option>

                                <template v-for="(category, index) in $root.sharedRootCategories">
                                    <option
                                        :key="index"
                                        selected="selected"
                                        :value="category.id"
                                        v-if="(category.id == searchedQuery.category)">
                                        @{{ category.name }}
                                    </option>

                                    <option :key="index" :value="category.id" v-else>
                                        @{{ category.name }}
                                    </option>
                                </template>
                            </select>

                            <div class="select-icon-container">
                                <span class="select-icon rango-arrow-down"></span>
                            </div>
                        </div>

                        <div class="w-100">

                            <div class="d-flex align-items-center">
                                <i class="ei-icon_search mr-3"></i>
                                <input
                                    required
                                    name="term"
                                    type="search"
                                    id="search-box"
                                    class="form-control search-box"
                                    :value="searchedQuery.term ? searchedQuery.term.split('+').join(' ') : ''"
                                    placeholder="{{ __('velocity::app.header.search-text') }}" />
                                <button class="btn" type="submit" id="header-search-icon">
                                    <i class="ei-icon_search"></i>
                                </button>
                                <a href="#" class="nav-link text-center d-flex align-items-center" @click.prevent="closeSearch">
                                    <i class="ei-icon_close mb-0"></i>
                                    <span class="mt-0">CANCEL</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</script>

<script type="text/x-template" id="sidebar-categories-template">
    <div class="wrapper" v-if="rootCategories">
        Hello World
    </div>

    <div class="wrapper" v-else-if="subCategory">
        Hello World 2
    </div>
</script>

<script type="text/javascript">
    (() => {
        Vue.component('cart-btn', {
            template: '#cart-btn-template',

            props: ['itemCount'],

            methods: {
                toggleMiniCart: function () {
                    this.$emit('open-cart');
                }
            }
        });

        Vue.component('close-btn', {
            template: '#close-btn-template',

            methods: {
                togglePopup: function () {
                    $('#cart-modal-content').hide();
                }
            }
        });

        Vue.component('quantity-changer', {
            template: '#quantity-changer-template',
            inject: ['$validator'],
            props: {
                controlName: {
                    type: String,
                    default: 'quantity'
                },

                quantity: {
                    type: [Number, String],
                    default: 1
                },

                minQuantity: {
                    type: [Number, String],
                    default: 1
                },

                validations: {
                    type: String,
                    default: 'required|numeric|min_value:1'
                }
            },

            data: function() {
                return {
                    qty: this.quantity
                }
            },

            watch: {
                quantity: function (val) {
                    this.qty = val;

                    this.$emit('onQtyUpdated', this.qty)
                }
            },

            methods: {
                decreaseQty: function() {
                    if (this.qty > this.minQuantity)
                        this.qty = parseInt(this.qty) - 1;

                    this.$emit('onQtyUpdated', this.qty)
                },

                increaseQty: function() {
                    this.qty = parseInt(this.qty) + 1;

                    this.$emit('onQtyUpdated', this.qty)
                }
            }
        });

        Vue.component('logo-component', {
            template: '#logo-template',
            props: ['addClass'],
        });

        Vue.component('searchbar-component', {
            template: '#searchbar-template',
            data: function () {
                return {
                    compareCount: 0,
                    wishlistCount: 0,
                    searchedQuery: [],
                    isCustomer: '{{ auth()->guard('customer')->user() ? "true" : "false" }}' == "true",
                }
            },

            watch: {
                '$root.headerItemsCount': function () {
                    this.updateHeaderItemsCount();
                }
            },

            created: function () {
                let searchedItem = window.location.search.replace("?", "");
                searchedItem = searchedItem.split('&');

                let updatedSearchedCollection = {};

                searchedItem.forEach(item => {
                    let splitedItem = item.split('=');
                    updatedSearchedCollection[splitedItem[0]] = splitedItem[1];
                });

                this.searchedQuery = updatedSearchedCollection;

                this.updateHeaderItemsCount();
            },

            methods: {
                closeSearch() {
                    this.$emit('close-search');
                },
                'focusInput': function (event) {
                    $(event.target.parentElement.parentElement).find('input').focus();
                },

                'updateHeaderItemsCount': function () {
                    if (! this.isCustomer) {
                        let comparedItems = this.getStorageValue('compared_product');
                        let wishlistedItems = this.getStorageValue('wishlist_product');

                        if (wishlistedItems) {
                            this.wishlistCount = wishlistedItems.length;
                        }

                        if (comparedItems) {
                            this.compareCount = comparedItems.length;
                        }
                    } else {
                        this.$http.get(`${this.$root.baseUrl}/items-count`)
                            .then(response => {
                                this.compareCount = response.data.compareProductsCount;
                                this.wishlistCount = response.data.wishlistedProductsCount;
                            })
                            .catch(exception => {
                                console.log(this.__('error.something_went_wrong'));
                            });
                    }
                }
            }
        });
    })()
</script>