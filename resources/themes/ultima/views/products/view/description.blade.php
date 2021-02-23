{!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

    <div class="product-description">
        <h4 class="description-title mb-3">Description</h4>
        <div class="full-description">
            {!! $product->description !!}
        </div>
    </div>

{!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}
{!! view_render_event('bagisto.shop.products.view.short_description.after', ['product' => $product]) !!}