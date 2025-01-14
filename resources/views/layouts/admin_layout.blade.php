@php
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }
@endphp

@if($isLogin)
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
            @if (isset($_SESSION["rapidx_user_id"]))
                <input type="hidden" id="loginEmployeeId" value="<?php echo $_SESSION["rapidx_user_id"]; ?>">
            @endif
            <div class="wrapper">
                    @include('shared.pages.header')
                    @include('shared.pages.facility_nav')
                    @include('shared.pages.footer')
                @yield('content_page')
            </div>

            <!-- JS LINKS -->
            @include('shared.js_links.js_links')
            @yield('js_content')
            <script type="text/javascript">
                $(document).ready(function(){
                    
                });
            </script>
        </body>
        <script>
            verifyUser();
            function verifyUser(){
                let loginEmployeeId = $('#loginEmployeeId').val();
                console.log('Session(Admin/User):', loginEmployeeId);
                $.ajax({
                    url: "get_user_log",
                    method: "get",
                    data: {
                        loginEmployeeId : loginEmployeeId
                    },
                    dataType: "json",

                    success: function(response){
                        console.log('object: ', response['rapidxDepartmentId']);
                        if (response['rapidxDepartmentId'] == 1) {
                            $('.userList').removeClass('d-none');
                        }
                        if(response['result'].length > 0){
                            for(let i = 0; i<response['result'].length;i++){
                                if(response['result'][i].classification == "1" || response['result'][i].classification == "2"){
                                    $('.userList').removeClass('d-none');
                                }
                            }
                        }else{
                            // window.location.href = '/RapidX';
                        }
                    }
                });
            }
        </script>
    </html>
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif
