<div class="col-lg-3 col-md-12 col-sm-12 footer-left text-center text-sm-left pl-0">
    @if ($ultimaMetaData)
        {!! $ultimaMetaData->footer_left_content !!}
    @else
        {!! __('velocity::app.admin.meta-data.footer-left-raw-content') !!}
    @endif
</div>