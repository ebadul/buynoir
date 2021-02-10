<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>@yield('page_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon'))
            <link rel="icon" sizes="16x16" href="{{ \Illuminate\Support\Facades\Storage::url($favicon) }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('vendor/webkul/ui/assets/images/favicon.ico') }}" />
        @endif
        
        <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin-buynoir.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">

        <style>
            .container {
                text-align: center;
                position: absolute;
                width: 100%;
                height: 100%;
                display: table;
                z-index: 1;
                background: #F8F9FA;
            }
            .center-box {
                display: table-cell;
                vertical-align: middle;
            }
            .adjacent-center {
                width: 365px;
                display: inline-block;
                text-align: left;
            }

            .form-container .control-group .control {
                width: 100%;
            }

            h1 {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 30px;
            }

            .brand-logo {
                margin-bottom: 30px;
                text-align: center;
            }

            .footer {
                margin-top: 40px;
                padding: 0 20px;
            }

            .footer p {
                font-size: 14px;
                color: #8E8E8E;
                text-align: center;
            }

            .btn.btn-primary {
                width: 100%;
            }

            .buynoir-panel form.buynoir-form-login label{
                font-size:25px;
                color:#aa5352;
                font-weight:bold;
                width:100%;
                margin-top:30px;
                margin-bottom:15px;
            }

            .buynoir-panel form.buynoir-form-login input{
                font-size:15px;
                color:#000 !important;
                font-weight:bold;
                width:100%;
                margin-bottom:5px;
                padding:17px !important;
                height: 50px;
            }
            .buynoir-panel form.buynoir-form-login input{
                font-size:15px;
                color:#000 !important;
                font-weight:bold;
                width:100%;
                margin-bottom:5px;
                padding:17px !important;
                height: 50px;
            }

                  .buynoir-panel form.buynoir-form-login input::placeholder{
                font-size:15px;
                color:#000 !important;
                
            }

            

            .buynoir-panel form.buynoir-form-login a,
            .buynoir-panel form.buynoir-form-login a:visited{
                  font-size:25px;
                color:#aa5352;
                font-weight:bold;
            }

            .buynoir-panel form.buynoir-form-login button{
                width:50%;
                box-shadow:none;
                font-size:20px;
                margin-top:15px;
            }

            .adjacent-center{
                width:450px;
            }

            .buynoir-panel{
                padding:20px;
            }

           .buynoir-panel .control-group .control {
               border:2px solid #aa5352;
           }

           #buynoir-panel-login{
               border:2.5px solid #aa5352;
           }
        </style>

        @yield('css')

        {!! view_render_event('bagisto.admin.layout.head') !!}
    </head>
    <body @if (core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif style="scroll-behavior: smooth;">
        <div id="app" class="container">

            <flash-wrapper ref='flashes'></flash-wrapper>

            <div class="center-box">

                <div class="adjacent-center">

                    <div class="brand-logo">
                        @if (core()->getConfigData('general.design.admin_logo.logo_image'))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url(core()->getConfigData('general.design.admin_logo.logo_image')) }}" alt="{{ config('app.name') }}" style="height: 40px; width: 110px;"/>
                        @else
                            <img src="{{ asset('vendor/webkul/ui/assets/images/logo-black.png') }}" alt="{{ config('app.name') }}"/>
                        @endif
                    </div>

                    {!! view_render_event('bagisto.admin.layout.content.before') !!}

                    @yield('content')

                    {!! view_render_event('bagisto.admin.layout.content.after') !!}

                    @if (core()->getConfigData('general.content.footer.footer_toggle'))
                        <div class="footer">
                            <p style="text-align: center;">
                                @if (core()->getConfigData('general.content.footer.footer_content'))
                                    {{ core()->getConfigData('general.content.footer.footer_content') }}
                                @else
                                    {!! trans('admin::app.footer.copy-right') !!}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

            </div>

        </div>

        <script type="text/javascript">
            window.flashMessages = [];
            @if ($success = session('success'))
                window.flashMessages = [{'type': 'alert-success', 'message': "{{ $success }}" }];
            @elseif ($warning = session('warning'))
                window.flashMessages = [{'type': 'alert-warning', 'message': "{{ $warning }}" }];
            @elseif ($error = session('error'))
                window.flashMessages = [{'type': 'alert-error', 'message': "{{ $error }}" }];
            @endif

            window.serverErrors = [];
            @if (isset($errors))
                @if (count($errors))
                    window.serverErrors = @json($errors->getMessages());
                @endif
            @endif
        </script>

        <script type="text/javascript" src="{{ asset('vendor/webkul/admin/assets/js/admin.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

        @stack('javascript')

        {!! view_render_event('bagisto.admin.layout.body.after') !!}

        <div class="modal-overlay"></div>
    </body>
</html>
