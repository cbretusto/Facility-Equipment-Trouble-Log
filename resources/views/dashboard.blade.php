@php
    session_start();
    $layout = 'layouts.admin_layout';
    if(isset($_SESSION['rapidx_user_id'])){
        $department = $_SESSION['rapidx_department_id'];
        if($department == 1 || isset($_SESSION['FETLS_user'])){
            if(isset($_SESSION['FETLS_user_access'])){
                $layout = 'layouts.admin_layout';
            }    
        }else{
            $layout = 'layouts.no_access_layout';
        }
    }
@endphp

@extends($layout)
@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="my-3">Dashboard</h2>
                    <div class="row userList d-none">
                        <div class="col-12">
                            <div class="small-box bg-dark bg-gradient shadow">
                                <a href="{{ route('user_management') }}">
                                    <div class="inner" style="height:100px;">
                                        <span class="info-box-text position-absolute mt-4 ml-3"><h4><strong>User Management</strong></h4></span>
                                        <div class="icon">
                                            <i class="fas fa-users mr-3" style="color: #d7d7db"></i>                                            
                                        </div>   
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-dark bg-gradient shadow">
                                <a href="{{ route('equipment') }}">
                                    <div class="inner" style="height:100px;">
                                        <span class="info-box-text position-absolute mt-4 ml-3"><h4><strong>Equipment List</strong></h4></span>
                                        <div class="icon">
                                            <i class="fa-solid fa-screwdriver-wrench mr-3" style="color: #d7d7db; font-size:75px;"></i>
                                        </div>   
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-dark bg-gradient shadow">
                                <a href="{{ route('fetls') }}">
                                    <div class="inner" style="height:100px;">
                                        <span class="info-box-text position-absolute mt-4 ml-3"><h4><strong>Trouble Logs</strong></h4></span>
                                        <div class="icon">
                                            <i class="fa-solid fa-book-bookmark mr-3" style="color: #d7d7db; font-size:75px;"></i>
                                        </div>   
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-dark bg-gradient shadow">
                                <a href="{{ route('export_report') }}">
                                    <div class="inner" style="height:100px;">
                                        <span class="info-box-text position-absolute mt-4 ml-3"><h4><strong>Report</strong></h4></span>
                                        <div class="icon">
                                            <i class="fa-solid fas fa-solid fa fa-file-excel mr-4" style="color: #d7d7db"></i>                                            
                                        </div>   
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

    {{-- // JS CONTENT
    @section('js_content')
        <script type="text/javascript">
        </script>
    @endsection --}}

