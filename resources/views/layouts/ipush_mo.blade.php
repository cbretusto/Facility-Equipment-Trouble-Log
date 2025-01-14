<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Facility Equipment Trouble Logs System| @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- CSS LINKS -->
        @include('shared.css_links.css_links')
        <style>
            .modal-xl-custom{
                width: 95% !important;
                min-width: 90% !important;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            @include('shared.pages.nav')
            <div class="row">
                <div class="col-6 bg-dark">
                    <div class="input-group">
                        <div class="input-group-prepend w-100">
                            <img src="{{ asset('public/images/struggle-crying.gif') }}" alt="" style="height:99%; width:100%;">
                        </div>
                    </div>
                </div>
                <div class="col-6 bg-dark">
                    <div class="input-group">
                        <div class="input-group-prepend w-100">
                            <img src="{{ asset('public/images/crying.gif') }}" alt="" style="height:95%; width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
