@php
    // @todo: Of course make dynamic / configurable. This is just for UI development.
    $brands = [
        ['image_url' => url('/themes/ultima/assets/images/brands/nike.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/adidas.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/forever-21.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/ck.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/adidas.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/adidas.png')],
        ['image_url' => url('/themes/ultima/assets/images/brands/adidas.png')],
    ];
@endphp
<div class="container">
    <brand-slider
        :brands="{{ json_encode($brands) }}" brands-text="{{ __('BRANDS YOU LOVE') }}">
    </brand-slider>
</div>