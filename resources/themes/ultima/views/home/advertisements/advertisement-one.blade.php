@php
    $isRendered = false;
    $advertisementOne = null;
@endphp

@if ($ultimaMetaData && $ultimaMetaData->advertisement)
    @php
        $advertisement = json_decode($ultimaMetaData->advertisement, true);
        if (isset($advertisement[2])) {
            $advertisementOne = $advertisement[2];
        }
    @endphp

    @if ($advertisementOne)
    @php
        $isRendered = true;
    @endphp

    <div class="container-fluid advertisement-two-container mb-section">
        <div class="row">
            @if ( isset($advertisementOne[1]))
                <a class="col-lg-12 col-md-12 no-padding">
                    <img src="{{ asset('/storage/' . $advertisementOne[1]) }}" />
                </a>
            @endif
        </div>
    </div>
    @endif
@endif

@if (! $isRendered)
    <div class="advertisement-two-container mb-section">
        <div class="w-100 overflow-hidden">
            <a>
                <img src="{{ asset('/themes/ultima/assets/images/banner_three.png') }}" />
            </a>
        </div>
    </div>
@endif