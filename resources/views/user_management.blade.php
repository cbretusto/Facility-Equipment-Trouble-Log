@php
    session_start();
    $layout = 'layouts.admin_layout';
    // $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        // $isLogin = true;
        $department = $_SESSION['rapidx_department_id'];
        if($department == 1 || isset($_SESSION['FETLS_user'])){
            $layout = 'layouts.admin_layout';
        }else{
            $layout = 'layouts.no_access_layout';
        }
    }
@endphp

{{-- @if($isLogin) --}}
    @extends($layout)
    @section('title', 'User List')
    @section('content_page')
        <style>
            .hidden_text {
                position: absolute;
                opacity: 0;
            }
        </style>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User Management</h1>
                        </div>
                        <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">User Management</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" style="margin-top: 8px;">User List</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">User List</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#approvers" type="button" role="tab">Approver List</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="users" role="tabpanel">
                                            <div class="text-right mt-4">                   
                                                <button type="button" class="btn btn-dark mb-3" id="buttonAddUser" data-bs-toggle="modal" data-bs-target="#modalUser"><i class="fa fa-plus fa-md"></i> New User</button>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tableUserList" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Employee No.</th>
                                                            <th>Name</th>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Position</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="approvers" role="tabpanel">
                                            <div class="text-right mt-4">                   
                                                <button type="button" class="btn btn-dark mb-3" id="buttonAddApprover" data-bs-toggle="modal" data-bs-target="#modalApprover"><i class="fa fa-plus fa-md"></i> New Approver</button>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table id="tableApproverList" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Name</th>
                                                            <th>Classification</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    
        <!-- Add User Modal Start -->
        <div class="modal fade" id="modalUser" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;User information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="formUser" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <!-- For User Id -->
                                        <input type="text" class="hidden_text" name="user_id" placeholder="User ID" id="textUserId">
                                        
                                        <div class="mb-3">
                                            <label for="employee_name" class="form-label">Employee Name:<span class="text-danger" title="Required">*</span></label>
                                            <select class="form-control slct2 slctEmployeeNo" name="employee_name" id="selectEmployeeName" placeholder="Employee No."></select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username:</label>
                                            <input type="text" class="form-control" name="username" id="textUsername" placeholder="Username" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_address" class="form-label">Email Address:<span class="text-danger" title="Required"></span></label>
                                            <input type="text" class="form-control" name="email_address" id="textEmailAddress" placeholder="Email Address" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="position" class="form-label">Position:<span class="text-danger" title="Required"></span></label>
                                            <input type="text" class="form-control" name="position" id="textPosition" placeholder="Position" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnUser" class="btn btn-dark"><i id="iBtnUserIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Add User Modal End -->

        <!-- User Status Modal Start -->
        <div class="modal fade" id="modalChangeUserStat" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeUserTitle"><i class="fa fa-user"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeUserStat">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeUserStatLabel"></label>
                            <input type="hidden" name="user_id" placeholder="User Id" id="txtChangeUserStatUserId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeUserStatUserStat">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeUserStat" class="btn btn-dark"><i id="iBtnChangeUserStatIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- User Status Modal End -->

        <!-- User Status Modal Start -->
        <div class="modal fade" id="modalRemoveApproverClassification" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-user"></i> Remove Approver</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formRemoveApproverClassification">
                        @csrf
                        <div class="modal-body">
                            <label>Do you really want to remove this?</label>
                            <input type="text" class="hidden_text" name="approver_user_id" placeholder="User Id" id="txtApproverUserId">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnRemoveApproverClassification" class="btn btn-dark"><i id="iBtnRemoveApproverClassificationIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- User Status Modal End -->

        <!-- Approver Modal Start -->
        <div class="modal fade" id="modalApprover" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fa fa-user"></i> Approver Name</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formApprover">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="hidden_text" name="approver_id" placeholder="Approver Id" id="txtApproverId" readonly>

                            <div class="mb-3">
                                <label for="approver_employee_no" class="form-label">Approver Name:<span class="text-danger" title="Required">*</span></label>
                                <select class="form-control slct2 slctApproverName selectReset" name="approver_employee_name" id="selectApproverEmployeeName" placeholder="Approver Name"></select>
                            </div>

                            <div class="mb-3">
                                <label for="classification" class="form-label">Classification:<span class="text-danger" title="Required">*</span></label>
                                <select class="form-control selectReset" name="classification" id="selectClassification" placeholder="Classification">
                                    <option selected value="" disabled>--- Select ---</option>
                                    <option value="1">Noted By</option>
                                    <option value="2">Checked By</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnApprover" class="btn btn-dark"><i id="iBtnAproverIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Approver Modal End -->
    @endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
    let dataTableUsers;
    let dataTableApprover;
        $(document).ready(function () {

            $('.slct2').select2({
                theme: 'bootstrap-5'
            });
            
            GetEmployeeName($(".slctEmployeeNo"));
            GetApproverName($(".slctApproverName"));

            dataTableUsers = $("#tableUserList").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ user records",
                        "lengthMenu": "Show _MENU_ user records",
                    },
                    "ajax" : {
                        url: "view_users",
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false},
                        { "data" : "status"},
                        { "data" : "rapidx_user_info.employee_number"},
                        { "data" : "rapidx_user_info.name"},
                        { "data" : "rapidx_user_info.username"},
                        { "data" : "rapidx_user_info.email"},
                        { "data" : "position"},
                    ],
                });

                dataTableApprover = $("#tableApproverList").DataTable({
                    "processing" : false,
                    "serverSide" : true,
                    "responsive": true,
                    // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                    "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ pending user records",
                        "lengthMenu": "Show _MENU_ pending user records",
                    },
                    "ajax" : {
                        url: "view_approver_list",
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false},
                        { "data" : "rapidx_user_info.name"},
                        { "data" : "classification",
                            defaultContent: 'N/A',
                                name: 'classification',
                                orderable: true,
                                searchable: true,
                                render: {
                                display: function (data, type, row) {
                                    if (row.classification == 1) {
                                        return "Noted By";
                                    }else{
                                        return "Checked By";
                                    }
                                },
                            },    
                        },
                    ],
                });

                $('#selectEmployeeName').change(function (e) { 
                    e.preventDefault();
                    let empID = $(this).val();
                    $.ajax({
                        url: 'get_employee_info',
                        method: 'get',
                        data: {
                            'emp_id': empID
                        },
                        beforeSend: function(){
                        
                        },
                        success: function(response){
                            let getData = response['rapidx_employee_id'];
                            let getPosition = response['result'];
                            let get;

                            console.log('getPosition',getPosition)
                            
                            if(getPosition == 'no_data'){
                                $("#formUser")[0].reset();
                                alert('The chosen user has already resigned.');
                            }else{
                                if(getPosition[0].position_info['Position'] == '-'){
                                    get = getPosition[0].section_info['Section']
                                }else{
                                    get = getPosition[0].position_info['Position']
                                }

                                $("input[name='username']", $("#formUser")).val(getData[0]['username']);
                                $("input[name='email_address']", $("#formUser")).val(getData[0]['email']);
                                $("input[name='position']", $("#formUser")).val(get);
                            }

                        }
                    });
                });

                $('#buttonAddApprover').click(function (e) { 
                    e.preventDefault();
                    $('.show').attr('disabled', true)
                });

                $("#formUser").submit(function(event){
                    event.preventDefault();
                    User();
                });

                $(document).on('click', '.actionEditUser', function(e){
                    e.preventDefault();

                    let UserId = $(this).attr('user-id'); 
                    $("#textUserId").val(UserId);

                    GetUserInfoByIdToEdit(UserId); 
                });

                $('#modalUser').on('hidden.bs.modal', function(event){
                    event.preventDefault();
                    $("#textUserId").val('');
                    $("#formUser")[0].reset();
                });

                $(document).on('click', '.actionChangeUserStat', function(){
                    let userStat = $(this).attr('status');
                    let userId = $(this).attr('user-id'); 
                    $("#txtChangeUserStatUserStat").val(userStat); 
                    $("#txtChangeUserStatUserId").val(userId); 

                    if(userStat == 1){
                        $("#lblChangeUserStatLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeUserTitle").html('<i class="fa fa-user"></i> Activate User');
                    }
                    else{
                        $("#lblChangeUserStatLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeUserTitle").html('<i class="fa fa-user"></i> Deactivate User');
                    }
                });

                $("#formChangeUserStat").submit(function(event){
                    event.preventDefault();
                    ChangeUserStatus();
                });

                $("#formApprover").submit(function(event){
                    event.preventDefault();
                    Approver();
                });

                $('#modalApprover').on('hidden.bs.modal', function(event){
                    event.preventDefault();
                    $(".selectReset").val('').trigger('change');
                    $('#formApprover')[0].reset();
                });

                $(document).on('click', '.actionRemoveClassification', function(e){
                    e.preventDefault();
                    let approverId = $(this).attr('user-id'); 
                    $("#txtApproverUserId").val(approverId);
                });

                $("#formRemoveApproverClassification").submit(function(event){
                    event.preventDefault();
                    ChangeApproverClassification();
                });

            });
        </script>
    @endsection
{{-- @else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif --}}