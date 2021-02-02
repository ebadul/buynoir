{!! view_render_event('bagisto.shop.layout.header.locale.before') !!}

    <div>
        <div class="dropdown">

            @php
                $localeImage = null;
                $activeLocale = core()->getCurrentChannel()->locales->filter(function ($locale) {
                    return $locale->code === app()->getLocale();
                })->first();
                $activeLocaleName = $activeLocale ? $activeLocale->name : app()->getLocale();
            @endphp
            @foreach (core()->getCurrentChannel()->locales as $locale)
                @if ($locale->code == app()->getLocale())
                    @php
                        $localeImage = $locale->locale_image;
                    @endphp
                @endif
            @endforeach

            <div class="dropdown show">
                <a class="dropdown-toggle nav-link text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ei-icon_globe-2 d-block"></i>
                    <span>{{ $activeLocaleName }}</span>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @foreach (core()->getCurrentChannel()->locales as $locale)
                        @if (isset($serachQuery))
                            <a class="dropdown-item"
                                href="?{{ $serachQuery }}&locale={{ $locale->code }}">
                                {{ $locale->name }}
                            </a>
                        @else
                            <a class="dropdown-item" href="?locale={{ $locale->code }}">
                                {{ $locale->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="select-icon-container">
                <span class="select-icon rango-arrow-down"></span>
            </div>
        </div>
    </div>

{!! view_render_event('bagisto.shop.layout.header.locale.after') !!}

{!! view_render_event('bagisto.shop.layout.header.currency-item.before') !!}

    @if (core()->getCurrentChannel()->currencies->count() > 1)
        <div>
            <div class="dropdown show">
                <a class="dropdown-toggle nav-link text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ei-icon_currency d-block"></i>
                    <span>{{ core()->getCurrentCurrencyCode() }}</span>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @foreach (core()->getCurrentChannel()->currencies as $currency)
                        @if (isset($serachQuery))
                            <a class="dropdown-item"
                                href="?{{ $serachQuery }}&currency={{ $currency->code }}">
                                {{ $currency->name }}
                            </a>
                        @else
                            <a class="dropdown-item" href="?currency={{ $currency->code }}">
                                {{ $currency->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

{!! view_render_event('bagisto.shop.layout.header.currency-item.after') !!}
