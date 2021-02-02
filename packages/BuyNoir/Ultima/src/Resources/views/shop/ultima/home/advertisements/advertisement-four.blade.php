@php
    $isRendered = false;
    $advertisementFour = null;
@endphp

@if ($ultimaMetaData && $ultimaMetaData->advertisement)
    @php
        $advertisement = json_decode($ultimaMetaData->advertisement, true);
        
        if (isset($advertisement[4]) && is_array($advertisement[4])) {
            $advertisementFour = array_values(array_filter($advertisement[4]));
        }
    @endphp

    @if ($advertisementFour)
        @php
            $isRendered = true;
        @endphp

        <div class="container mb-section">
            <div class="advertisement-four-container">
                <div class="row">
                    @if ( isset($advertisementFour[0]))
                        <div class="col-md-6 pl-0">
                            <a @if (isset($one)) href="{{ $one }}" @endif class="col-lg-4 col-12 no-padding">
                                <img class="col-12 offers-image-top" src="{{ asset('/storage/' . $advertisementFour[0]) }}" />
                            </a>
                        </div>
                    @endif

                    <div class="col-md-6 col-12 offers-ct-panel d-flex flex-column justify-content-between">
                        
                        @if ($ultimaMetaData)
                            {!! $ultimaMetaData->advertisement_four_content !!}
                        @endif
                        
                        <div class="d-flex overflow-hidden flex-wrap flex-md-nowrap justify-content-center justify-content-md-start">
                            @if ( isset($advertisementFour[1]))
                                <a @if (isset($two)) href="{{ $two }}" @endif class="mr-3 mb-3 mb-md-0">
                                    <img class="offers-ct-bottom" src="{{ asset('/storage/' . $advertisementFour[1]) }}" />
                                </a>
                            @endif
                            @if ( isset($advertisementFour[2]))
                                <a @if (isset($three)) href="{{ $three }}" @endif>
                                    <img class="offers-ct-bottom" src="{{ asset('/storage/' . $advertisementFour[2]) }}" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@if (! $isRendered)
    <div class="container mb-section">
        <div class="advertisement-four-container">
            <div class="row">
                <div class="col-md-6 pl-0">
                    <a @if (isset($one)) href="{{ $one }}" @endif>
                        <img class="col-12 offers-image-top" src="{{ asset('/themes/ultima/assets/images/ad_one.png') }}" />
                    </a>
                </div>

                <div class="col-md-6 col-12 offers-ct-panel d-flex flex-column justify-content-between">
                    
                    @if ($ultimaMetaData)
                        {!! $ultimaMetaData->advertisement_four_content !!}
                    @endif

                    <div class="d-flex overflow-hidden flex-wrap flex-md-nowrap justify-content-center justify-content-md-start">
                        <a @if (isset($two)) href="{{ $two }}" @endif class="mr-3 mb-3 mb-md-0">
                            <img class="offers-ct-top" src="{{ asset('/themes/ultima/assets/images/ad_two.png') }}" />
                        </a>
                        <a @if (isset($three)) href="{{ $three }}" @endif>
                            <img class="offers-ct-bottom" src="{{ asset('/themes/ultima/assets/images/ad_three.png') }}" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif