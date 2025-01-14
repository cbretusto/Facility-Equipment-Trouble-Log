@php
    session_start();
    $layout = 'layouts.admin_layout';
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
        $department = $_SESSION['rapidx_department_id'];
        if($department == 1 || isset($_SESSION['FETLS_user'])){
            $layout = 'layouts.admin_layout';
        }else{
            $layout = 'layouts.no_access_layout';
        }
    }
@endphp

@if($isLogin)
    @extends($layout)
    @section('title', 'Trouble Logs')
    @section('content_page')
        <style>
            .hidden_text {
                position: absolute;
                opacity: 0;
            }
            table.table tbody td{
                margin: 2px 2px;
                font-size: 13px;
                vertical-align: middle;
            }

            table.table thead th{
                padding: 7px 7px;
                margin: 2px 2px;
                font-size: 14px;
                text-align: center;
                vertical-align: middle;
            }
        </style>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Trouble Logs Management</h1>
                        </div>
                        <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Trouble Logs Management</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row pb-5">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title p-2"><strong>Trouble Logs Details</strong></h3>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <select class="nav-link" name="fetl_category" id="FETLcategory" data-bs-toggle="tab" data-bs-target="#fetlsApproval" role="tab">
                                                <option selected value="0">For Approval</option>
                                                <option value="1">Approved</option>
                                                <option value="2">Disapproved</option>
                                                <option value="3">Done</option>
                                            </select>
                                            {{-- <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fetlsApproval" type="button" role="tab">For Approval</button> --}}
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            {{-- <button class="nav-link" data-bs-toggle="tab" data-bs-target="#approvers" type="button" role="tab">Approved</button> --}}
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            {{-- <button class="nav-link" data-bs-toggle="tab" data-bs-target="#approvers" type="button" role="tab">Disapproved</button> --}}
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="fetlsApproval" role="tabpanel">
                                            <div class="text-right mt-4">                   
                                                <button type="button" class="btn btn-dark mb-3" id="buttonAddFETL" data-bs-toggle="modal" data-bs-target="#modalFETL"><i class="fa fa-plus fa-md"></i> Add Details</button>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="tableFETLForApproval" class="table table-bordered table-hover" style="width: 100%; white-space: pre-wrap;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Approval Status</th>
                                                            <th>Control No.</th>
                                                            <th>Equipment</th>
                                                            <th>Equipment Model</th>
                                                            <th>Date of Trouble</th>
                                                            <th>Trouble</th>
                                                            <th>Location of Equipment</th>
                                                            <th>Parts Needed</th>
                                                            <th>Date: <br> Parts Replaced</th>
                                                            <th>Trouble Status</th>
                                                            <th>Action Done</th>
                                                            <th>Remarks</th>
                                                            <th>Created By</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane fade" id="approvers" role="tabpanel">
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
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Trouble Logs Modal Start -->
            <div class="modal fade" id="modalFETL" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Trouble Logs information</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" id="formFETL" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <input type="text" class="hidden_text" id="txtFETLId" name="FETL_id" placeholder="FETL Id">
                                <div class="row"><!-- Start Row MIMF Data -->
                                    <div class="col-6 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Control No.
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLControlNo" name="FETL_control_no" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100"><strong>Date</strong></span>
                                            </div>
                                            <input type="date" class="form-control" id="dateFETLDate" name="FETL_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Equipment
                                                    </strong>
                                                </span>
                                            </div>
                                            <select class="form-control select2bs5 get-equipment" id="slctFETLEquipment" name="FETL_equipment" required></select>    
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Equipment Model
                                                    </strong>
                                                </span>
                                            </div>
                                            <select class="form-control select2bs5 get-equipment-model" id="slctFETLEquipmentModel" name="FETL_equipment_model" required></select>    
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Parts Needed
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLPartsNeeded" name="FETL_parts_needed" required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Location of Equipment
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLLocationOfEquipment" name="FETL_location_of_equipment" required>
                                        </div>
                                    </div>
    
                                    <div class="col-6 mt-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Created By
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLCreatedBy" name="FETL_created_by" value="{{ $_SESSION['rapidx_name'] }}" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Noted By
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLNotedBy" name="FETL_noted_by" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Checked By
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLCheckedBy" name="FETL_checked_by" readonly required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Status
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="txtFETLStatus" name="FETL_status">
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Date Parts Replaced
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" id="dateFETLDatePartsReplaced" name="FETL_date_parts_replaced">
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100">
                                                    <strong>
                                                        Date of Trouble
                                                    </strong>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" id="dateFETLDateOfTrouble" name="FETL_date_of_trouble">
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text w-100">
                                            <strong>
                                                Trouble
                                            </strong>
                                        </span>
                                    </div>
                                    <textarea type="text" class="form-control text-area" id="txtFETLTrouble" name="FETL_trouble"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text w-100">
                                            <strong>
                                                Action Done
                                            </strong>
                                        </span>
                                    </div>
                                    <textarea type="text" class="form-control text-area" id="txtFETLActionDone" name="FETL_action_done"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text w-100">
                                            <strong>
                                                Remark
                                            </strong>
                                        </span>
                                    </div>
                                    <textarea type="text" class="form-control text-area" id="txtFETLRemark" name="FETL_remark"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-between FETL-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="btnFETL" class="btn btn-dark"><i id="iBtnFETLIcon" class="fa fa-check"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Trouble Logs Modal End -->

            <!-- Trouble Logs Status Modal Start -->
            <div class="modal fade" id="modalChangeFETLStatus" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h4 class="modal-title" id="h4ChangeFETLTitle"><i class="fa-solid fa-screwdriver-wrench"></i> Change Status</h4>
                            <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="formChangeFETLStatus">
                            @csrf
                            <div class="modal-body">
                                <label id="lblChangeFETLStatLabel"></label>
                                <input type="hidden" name="status_FETL_id" placeholder="FETL Id" id="txtChangeStatusFETLId">
                                <input type="hidden" name="status" placeholder="Status" id="txtChangeFETLStatus">
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                                <button type="submit" id="btnChangeFETLStatus" class="btn btn-dark"><i id="iBtnChangeFETLStatusIcon" class="fa fa-check"></i> Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Trouble Logs Status Modal End -->

            <!-- Trouble Logs Approval Modal Start -->
            <div class="modal fade" id="modalChangeFETLApproval" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header button-color">
                            <h4 class="modal-title" id="h4ChangeFETLApprovalTitle"><i class="fa-solid fa-screwdriver-wrench"></i> Approval Information</h4>
                            <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="formChangeFETLApproval">
                            @csrf
                            <div class="modal-body">
                                <label id="lblChangeFETLApprovalLabel"></label>
                                <input type="text" class="hidden_text" name="approval_FETL_id" placeholder="FETL Id" id="txtChangeApprovalFETLId">
                                <input type="text" class="hidden_text" name="approval_status" placeholder="Approval" id="txtChangeFETLApprovalStatus">
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                                <button type="submit" id="btnChangeFETLApproval" class="btn button-color"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Trouble Logs Approval Modal End -->

            <!-- Trouble Logs Done By Modal Start -->
            <div class="modal fade" id="modalFETLDoneBy" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h4 class="modal-title"><i class="fa-solid fa-screwdriver-wrench"></i> Done By:</h4>
                            <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="formFETLDoneBy">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="fetl_id_for_done_by" placeholder="Done By:" id="txtFETLIdForDoneBy">
                                    <div class="input-group">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    Done By:
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="txtFETLUserForDoneBy" name="fetl_user_for_done_by" value="{{ $_SESSION['rapidx_name'] }}" readonly required>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                                <button type="submit" id="btnFETLDoneBy" class="btn btn-dark"><i id="iBtnFETLDoneByIcon" class="fa fa-check"></i> Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Trouble Logs Status Modal End -->            

        </div>
    @endsection

    <!-- JS CONTENT --}} -->
    @section('js_content')
        <script type="text/javascript">
            let dataTableTroubleLogs
            let dataTableFETLModel
            let category

            $(document).ready(function () {
                $('.select2bs5').select2({
                    theme: 'bootstrap-5'
                })          
                
                $('#FETLcategory').change(function (e) { 
                    e.preventDefault();
                    category = $('#FETLcategory').val()
                    console.log('category: ', category);
                    dataTableTroubleLogs.draw()
                    
                });
                dataTableTroubleLogs = $("#tableFETLForApproval").DataTable({
                    "processing" : false,
                    "serverSide" : true,
                    "responsive": true,
                    // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                    "language": {
                            "info": "Showing _START_ to _END_ of _TOTAL_ Trouble Logs Records",
                            "lengthMenu": "Show _MENU_ Trouble Logs Records",
                        },
                        "ajax" : {
                            url: "view_trouble_logs_approval",
                            data: function(param){
                                param.category  =  $('#FETLcategory').val()
                            }
                        },
                        "columns":[
                            { "data" : "action", orderable:false, searchable:false},
                            { "data" : "approval_status"},
                            { "data" : "control_no"},
                            { "data" : "trouble_logs_equipment_info.equipment"},
                            { "data" : "trouble_logs_equipment_model_info.equipment_model"},
                            { "data" : "date_of_trouble"},
                            { "data" : "trouble"},
                            { "data" : "location_of_equipment"},
                            { "data" : "parts_needed"},
                            { "data" : "date_parts_replaced"},
                            { "data" : "fetls_status"},
                            { "data" : "action_done"},
                            { "data" : "remark"},
                            { "data" : "created_by_info.name"},
                        ],
                });

                $('#slctFETLEquipment').change(function (e) { 
                    e.preventDefault();
                    let getValue = $(this).val()
                    GetEquipmentModel($('.get-equipment-model'),getValue)
                });

                $('#buttonAddFETL').click(function (e) { 
                    e.preventDefault();
                    $('.FETL-footer').removeClass('d-none')
                    GetEquipment($('.get-equipment'))

                    $.ajax({
                        url: "new_control_no",
                        method: "get",
                        dataType: "json",

                        beforeSend: function(){
                        },
                        success: function(response){
                            let newControlNo = response['new_control_number']
                            let getUser = response['get_user']

                            $('#txtFETLControlNo').val(newControlNo)

                            for (let index = 0; index < getUser.length; index++) {     
                                if(getUser[index].classification == 1){
                                    $('#txtFETLNotedBy').val(getUser[index].rapidx_user_info.name)
                                }else{
                                    $('#txtFETLCheckedBy').val(getUser[index].rapidx_user_info.name)
                                }
                            }
                        }
                    });
                });

                $(document).on('click', '.actionEditFETL', function(e){
                    e.preventDefault();
                    let FETLId = $(this).attr('FETL-id')
                    $("#txtFETLId").val(FETLId)
                    $('.FETL-footer').removeClass('d-none')
                    GetFETLByIdToEdit(FETLId)
                });

                $(document).on('click', '.actionViewFETL', function(e){
                    e.preventDefault();
                    let FETLId = $(this).attr('FETL-id')
                    $("#txtFETLId").val(FETLId)
                    $('.FETL-footer').addClass('d-none')
                    GetFETLByIdToEdit(FETLId)
                });

                $('#formFETL').submit(function (e) { 
                    e.preventDefault();
                    FETL()
                });

                $(document).on('click', '.actionChangeFETLStatus', function(){
                    let FETLStatus = $(this).attr('status');
                    let FETLId = $(this).attr('FETL-id'); 
                    $("#txtChangeFETLStatus").val(FETLStatus); 
                    $("#txtChangeStatusFETLId").val(FETLId); 

                    if(FETLStatus == 1){
                        $("#lblChangeFETLStatLabel").text('Are you sure to activate?'); 
                        $("#h4ChangeFETLTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Activate');
                    }
                    else{
                        $("#lblChangeFETLStatLabel").text('Are you sure to deactivate?');
                        $("#h4ChangeFETLTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Deactivate');
                    }
                });

                $("#formChangeFETLStatus").submit(function(event){
                    event.preventDefault();
                    ChangeFETLStatus();
                });

                $(document).on('click', '.actionChangeFETLApproval', function(){
                    let FETLStatus = $(this).attr('status');
                    console.log('status: ',FETLStatus);
                    let FETLId = $(this).attr('FETL-id'); 
                    $("#txtChangeFETLApprovalStatus").val(FETLStatus); 
                    $("#txtChangeApprovalFETLId").val(FETLId); 

                    if(FETLStatus == 2 || FETLStatus == 3){
                        $(".button-color").addClass('bg-success'); 
                        $(".button-color").removeClass('bg-danger'); 
                        $("#btnChangeFETLApproval").text('Approve'); 
                        $("#lblChangeFETLApprovalLabel").text('Do you sure want to approve the request?'); 
                        $("#h4ChangeFETLApprovalTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Approve Request');
                    }
                    else{
                        $(".button-color").addClass('bg-danger'); 
                        $(".button-color").removeClass('bg-success'); 
                        $("#btnChangeFETLApproval").text('Disapprove');
                        $("#lblChangeFETLApprovalLabel").text('Do you sure want to disapprove the request?');
                        $("#h4ChangeFETLApprovalTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Disapprove Request');
                    }
                });

                $("#formChangeFETLApproval").submit(function(event){
                    event.preventDefault();
                    ChangeFETLApproval();
                });

                $('#modalFETL').on('hidden.bs.modal', function(event){
                    event.preventDefault();
                    $("#formFETL")[0].reset();
                    $('#slctFETLEquipment').val('')
                    $('#slctFETLEquipmentModel').val('')
                });

                $(document).on('click', '.actionFETLDoneBy', function(e){
                    e.preventDefault();
                    let FETLIdForDoneBy = $(this).attr('FETL-id')
                    $("#txtFETLIdForDoneBy").val(FETLIdForDoneBy)
                });

                $('#formFETLDoneBy').submit(function (e) { 
                    e.preventDefault();
                    AddFETLDoneBy()
                });
            });
        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif