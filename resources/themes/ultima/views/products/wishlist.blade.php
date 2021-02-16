@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

{!! view_render_event('bagisto.shop.products.wishlist.before') !!}
    @auth('customer')
        @php
            $isWished = $wishListHelper->getWishlistProduct($product);
        @endphp

        <a
            class="unset wishlist-icon {{ $addWishlistClass ?? '' }}"
            @if(isset($route))
                href="{{ $route }}"
            @elseif (! $isWished)
                href="{{ route('customer.wishlist.add', $product->product_id) }}"
                title="{{ __('ultima::app.shop.wishlist.add-wishlist-text') }}"
            @elseif (isset($itemId) && $itemId)
                href="{{ route('customer.wishlist.remove', $itemId) }}"
                title="{{ __('ultima::app.shop.wishlist.remove-wishlist-text') }}"
            @endif>

            <wishlist-component active="{{ !$isWished }}" is-customer="true"></wishlist-component>

            @if (isset($text))
                {!! $text !!}
            @endif
        </a>
    @endauth

    @guest('customer')
        <wishlist-component
            active="false"
            is-customer="false"
            text="{{ $text ?? null }}"
            product-id="{{ $product->id }}"
            item-id="{{ $item->id ?? null}}"
            product-slug="{{ empty($product->url_key)?$product->name:$product->url_key }}"
            add-class="{{ $addWishlistClass ?? '' }}"
            move-to-wishlist="{{ $isMoveToWishlist ?? null}}"
            added-text="{{ __('shop::app.customer.account.wishlist.add') }}"
            remove-text="{{ __('shop::app.customer.account.wishlist.remove') }}">
        </wishlist-component>
    @endauth
{!! view_render_event('bagisto.shop.products.wishlist.after') !!}