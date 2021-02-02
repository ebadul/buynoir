@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')

{!! view_render_event('bagisto.shop.products.list.toolbar.before') !!}
    <toolbar-component></toolbar-component>
{!! view_render_event('bagisto.shop.products.list.toolbar.after') !!}

@push('scripts')
    <script type="text/x-template" id="toolbar-template">
        <div class="toolbar-wrapper" v-if='!isMobile()'>
            <div class="d-flex justify-content-between align-items-center">
                <div></div>
                @if (isset($products))
                <div>
                    <p class="results-count">{{ __(':number styles found', ['number' => $products->total()]) }}</p>
                </div>
                @endif
                @if (isset($results))
                <div>
                    <p class="results-count">{{ $results->total() }} {{ __('shop::app.search.found-results') }}</p>
                </div>
                @endif
                <div class="sorter">
                    <div class="dropdown show">
                        <a class="dropdown-toggle text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-underline">{{ __('shop::app.products.sort-by') }}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($toolbarHelper->getAvailableOrders() as $key => $order)
                                <a class="dropdown-item {{ $toolbarHelper->isOrderCurrent($key) ? 'active' : '' }}" href="{{ $toolbarHelper->getOrderUrl($key) }}">
                                    {{ __('shop::app.products.' . $order) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="toolbar-wrapper row col-12 remove-padding-margin" v-else>
            <div
                v-if="layeredNavigation"
                class="nav-container scrollable"
                style="
                    z-index: 1000;
                    color: black;
                    position: relative;
                ">
                <div class="header drawer-section">
                    <i class="ei-arrow_left" @click="toggleLayeredNavigation"></i>

                    <span class="fs24 fw6">
                        {{ __('velocity::app.shop.general.filter') }}
                    </span>
                    <span class="pull-right link-color" @click="toggleLayeredNavigation">
                        {{ __('velocity::app.responsive.header.done') }}
                    </span>
                </div>

                @if (request()->route()->getName() != 'velocity.search.index')
                    @include ('shop::products.list.layered-navigation')
                @endif
            </div>

            <div class="col-6 mx-0" @click="toggleLayeredNavigation({event: $event, actionType: 'open'})">
                <a class="unset">
                    <i class="ei-icon_adjust-horiz"></i>
                    <span>{{ __('velocity::app.shop.general.filter') }}</span>
                </a>
            </div>

            <div class="col-6 mx-0 text-right">
                <div class="dropdown show">
                    <a class="dropdown-toggle text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ei-arrow_up-down_alt"></i>
                    <span>{{ __('shop::app.products.sort-by') }}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @foreach ($toolbarHelper->getAvailableOrders() as $key => $order)
                            <a class="dropdown-item {{ $toolbarHelper->isOrderCurrent($key) ? 'active' : '' }}" href="{{ $toolbarHelper->getOrderUrl($key) }}">
                                {{ __('shop::app.products.' . $order) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="text/javascript">
        (() => {
            Vue.component('toolbar-component', {
                template: '#toolbar-template',
                data: function () {
                    return {
                        'layeredNavigation': false,
                    }
                },

                watch: {
                    layeredNavigation: function (value) {
                        if (value) {
                            document.body.classList.add('open-hamburger');
                        } else {
                            document.body.classList.remove('open-hamburger');
                        }
                    }
                },

                methods: {
                    toggleLayeredNavigation: function ({event, actionType}) {
                        this.layeredNavigation = !this.layeredNavigation;
                    }
                }
            })
        })()
    </script>
@endpush
