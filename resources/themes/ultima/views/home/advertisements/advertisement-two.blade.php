@php
    $isRendered = false;
    $advertisementTwo = null;
@endphp

@if ($ultimaMetaData && $ultimaMetaData->advertisement)
    @php
        $advertisement = json_decode($ultimaMetaData->advertisement, true);
        
        if (isset($advertisement[2]) && is_array($advertisement[2])) {
            $advertisementTwo = array_values(array_filter($advertisement[2]));
        }
    @endphp

    @if ($advertisementTwo)
        @php
            $isRendered = true;
        @endphp

        <div class="container-fluid advertisement-two-container overflow-hidden mb-section">
            <div class="row">
                @if ( isset($advertisementTwo[0]))
                    <a class="col-lg-12 col-md-12 no-padding">
                        <img src="{{ asset('/storage/' . $advertisementTwo[0]) }}" />
                    </a>
                @endif
            </div>
        </div>
    @endif
@endif

@if (! $isRendered)
    <div class="container-fluid advertisement-two-container overflow-hidden mb-section">
        <div class="row">
            <a class="col-lg-12 col-md-12 no-padding">
                <img src="{{ asset('/themes/ultima/assets/images/banner_two.jpeg') }}" />
            </a>
        </div>
    </div>
@endif