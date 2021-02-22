@php
    $velocityContent = app('Webkul\Velocity\Repositories\ContentRepository')->getAllContents();
@endphp
<header class="sticky-header header-main" v-if="!isMobile()">
    @if ($ultimaMetaData)
        {!! $ultimaMetaData->top_ribbon !!}
    @endif
    
    <div class="row col-12 justify-content-center header-main-content px-4 mx-0">
        <div class="small-col d-flex">
            @include('ultima::layouts.header.locale-currency')
        </div>
        <div class="col position-static">
            <div class="text-center logo-wrapper mb-4">
                <logo-component></logo-component>
            </div>
            <category-links :header-content="{{ json_encode($velocityContent) }}"></category-links>
        </div>
        <div class="small-col text-right" >
            @include('ultima::layouts.header.link-section')
        </div>
    </div>
</header>
<div class="mobile-header" v-else>
    <content-header
        url="{{ url()->to('/') }}"
        :header-content="{{ json_encode($velocityContent) }}"
        heading= "{{ __('velocity::app.menu-navbar.text-category') }}"
    ></content-header>
</div>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 59){
                    document.querySelector('header').classList.add('header-shadow');
                    document.querySelector('body').classList.add('fixed-nav');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                    document.querySelector('body').classList.remove('fixed-nav');
                }
            });
        })()
    </script>
@endpush
