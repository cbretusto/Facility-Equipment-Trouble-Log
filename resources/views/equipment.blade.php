@php
    session_start();
    $layout = 'layouts.admin_layout';
    if(isset($_SESSION['rapidx_user_id'])){
        $department = $_SESSION['rapidx_department_id'];
        if($department == 1 || isset($_SESSION['FETLS_user'])){
            $layout = 'layouts.admin_layout';
        }else{
            $layout = 'layouts.no_access_layout';
        }
    }
@endphp

@extends($layout)
@section('title', 'Equipment List')
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
                        <h1>Equipment Management</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Equipment Management</li>
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
                                <h3 class="card-title" style="margin-top: 8px;">Equipment Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="text-right">                   
                                    <button type="button" class="btn btn-dark mb-3" id="buttonAddEquipment" data-bs-toggle="modal" data-bs-target="#modalEquipment"><i class="fa fa-plus fa-md"></i> New Equipment</button>
                                </div>
                                <div class="table-responsive">
                                    <table id="tableEquipment" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Equipment Name</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Equipment Modal Start -->
        <div class="modal fade" id="modalEquipment" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Equipment information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="formEquipment" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="card-body">
                                <input type="text" class="hidden_text" name="equipment_id" id="textEquipmentId" placeholder="Equipment ID">
                                <label for="equipment" class="form-label">Equipment Name:</label>
                                <input type="text" class="form-control" name="equipment" id="textEquipment" placeholder="Equipment">
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnEquipment" class="btn btn-dark"><i id="iBtnEquipmentIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Equipment Modal End -->

        <!-- Equipment Status Modal Start -->
        <div class="modal fade" id="modalChangeEquipmentStatus" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeEquipmentTitle"><i class="fa fa-user"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeEquipmentStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeEquipmentStatLabel"></label>
                            <input type="hidden" name="equipment_id" placeholder="Equipment Id" id="txtChangeStatusEquipmentId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeEquipmentStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeEquipmentStatus" class="btn btn-dark"><i id="iBtnChangeEquipmentStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Equipment Status Modal End -->

        <!-- View Equipment List Modal Start -->
        <div class="modal fade" id="modalViewEquipmentModel" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;View Equipment List</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="formViewEquipmentModel" autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <input type="text" class="hidden_text" name="view_equipment_id" id="textViewEquipmentId" placeholder="Equipment ID">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100"><strong>Equipment</strong></span>
                                    </div>
                                    <input type="text" class="form-control" id="txtViewEquipment" name="view_equipment" readonly>
                                </div>

                                <div class="input-group">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100"><strong>Equipment Model</strong></span>
                                    </div>
                                    <input type="text" class="form-control" id="txtEquipmentModel" name="equipment_model">
                                    <button type="submit" class="btn btn-dark" id="btnViewEquipmentModel">&emsp;<i class="fa fa-save" id="iBtnViewEquipmentModelIcon"></i> &nbsp;Save Model&emsp;</button>
                                </div>
                            </div>
                        </form>
                        <hr class="mt-3 mb-3">
                        <div class="table-responsive">
                            <table id="tableViewEquipmentModel" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Status</th>
                                        <th>Equipment Model</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- View Equipment List Modal End -->

        <!-- Equipment Model Modal Start -->
        <div class="modal fade" id="modalEquipmentModel" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Equipment Model information</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="formEquipmentModel" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="card-body">
                                <input type="text" class="hidden_text" name="equipment_model_id" id="textEditEquipmentId" placeholder="Equipment Model ID">
                                <label for="equipment" class="form-label">Equipment Model:</label>
                                <input type="text" class="form-control" name="equipment_model" id="textEditEquipmentModel" placeholder="Equipment">
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnEquipmentModel" class="btn btn-dark"><i id="iBtnEquipmentModelIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Equipment Model Modal End -->

        <!-- Equipment Model Status Modal Start -->
        <div class="modal fade" id="modalChangeEquipmentModelStatus" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title" id="h4ChangeEquipmentModelTitle"><i class="fa fa-user"></i> Change Status</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formChangeEquipmentModelStatus">
                        @csrf
                        <div class="modal-body">
                            <label id="lblChangeEquipmentModelStatLabel"></label>
                            <input type="hidden" name="equipment_model_id" placeholder="Equipment Model Id" id="txtChangeStatusEquipmentModelId">
                            <input type="hidden" name="status" placeholder="Status" id="txtChangeEquipmentModelStatus">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">No</button>
                            <button type="submit" id="btnChangeEquipmentModelStatus" class="btn btn-dark"><i id="iBtnChangeEquipmentModelStatusIcon" class="fa fa-check"></i> Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- Equipment Model Status Modal End -->
        
    </div>

@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        let dataTableEquipment
        let dataTableEquipmentModel
        $(document).ready(function () {
            $('.slct2').select2({
                theme: 'bootstrap-5'
            });
            
            dataTableEquipment = $("#tableEquipment").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ equipment records",
                        "lengthMenu": "Show _MENU_ equipment records",
                    },
                    "ajax" : {
                        url: "view_equipments",
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false},
                        { "data" : "status"},
                        { "data" : "equipment"},
                    ],
            });

            $(document).on('click', '.actionEditEquipment', function(e){
                e.preventDefault();
                let equipmentId = $(this).attr('equipment-id')
                $("#textEquipmentId").val(equipmentId)
                GetEquipmentInfoByIdToEdit(equipmentId)
            });

            $("#formEquipment").submit(function(event){
                event.preventDefault()
                Equipments()
            });

            $(document).on('click', '.actionChangeEquipmentStatus', function(){
                let equipmentStatus = $(this).attr('status')
                let equipmentId = $(this).attr('equipment-id') 
                $("#txtChangeEquipmentStatus").val(equipmentStatus)
                $("#txtChangeStatusEquipmentId").val(equipmentId)

                if(equipmentStatus == 1){
                    $("#lblChangeEquipmentStatLabel").text('Are you sure to activate?'); 
                    $("#h4ChangeEquipmentTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Activate Equipment')
                }
                else{
                    $("#lblChangeEquipmentStatLabel").text('Are you sure to deactivate?');
                    $("#h4ChangeEquipmentTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Deactivate Equipment')
                }
            });

            $("#formChangeEquipmentStatus").submit(function(event){
                event.preventDefault();
                ChangeEquipmentStatus();
            });

            $(document).on('click', '.actionViewEquipmentModel', function(e){
                e.preventDefault()
                let viewEquipmentId = $(this).attr('equipment-id')
                $("#textViewEquipmentId").val(viewEquipmentId)
                GetEquipmentNameInfoByIdToEdit(viewEquipmentId)

                dataTableEquipmentModel = $("#tableViewEquipmentModel").DataTable({
                    "processing" : false,
                    "serverSide" : true,
                    "responsive": true,
                    "destroy"       : true,
                    // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                    "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ view equipment records",
                        "lengthMenu": "Show _MENU_ view equipment records",
                    },
                    "ajax" : {
                        url: "view_equipment_model",
                        data: function(param){
                        param.viewEquipmentId  =  viewEquipmentId
                    }
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false},
                        { "data" : "status"},
                        { "data" : "equipment_model"},
                    ],
                })
            })

            $("#formViewEquipmentModel").submit(function(event){
                event.preventDefault()
                AddEquipmentModel()
            })

            $(document).on('click', '.actionEditEquipmentModel', function(e){
                e.preventDefault()
                let equipmentModelId = $(this).attr('equipment_model-id');
                $("#textEditEquipmentId").val(equipmentModelId)
                GetEquipmentModelInfoByIdToEdit(equipmentModelId);
            })

            $("#formEquipmentModel").submit(function(event){
                event.preventDefault()
                EditEquipmentModel()
            })

            $('#modalViewEquipmentModel').on('hidden.bs.modal', function() {
                $('#txtEquipmentModel').val('')
            })

            $(document).on('click', '.actionChangeEquipmentModelStatus', function(){
                let equipmentModelStatus = $(this).attr('status')
                let equipmentModelId = $(this).attr('equipment_model-id') 
                $("#txtChangeEquipmentModelStatus").val(equipmentModelStatus)
                $("#txtChangeStatusEquipmentModelId").val(equipmentModelId)

                if(equipmentModelStatus == 1){
                    $("#lblChangeEquipmentModelStatLabel").text('Are you sure to activate?'); 
                    $("#h4ChangeEquipmentModelTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Activate Equipment Model')
                }
                else{
                    $("#lblChangeEquipmentModelStatLabel").text('Are you sure to deactivate?');
                    $("#h4ChangeEquipmentModelTitle").html('<i class="fa-solid fa-screwdriver-wrench"></i> Deactivate Equipment Model')
                }
            });

            $("#formChangeEquipmentModelStatus").submit(function(event){
                event.preventDefault();
                ChangeEquipmentModelStatus();
            });


        });
    </script>
@endsection
