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
@section('title', 'Export Report')
@section('content_page')
    @php
        date_default_timezone_set('Asia/Manila');
    @endphp
    <div class="content-wrapper">
        <section class="content p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Facility Equipment Trouble Logs</h5>
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('message') }}</strong>
                                    </div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">Equipment:</span>
                                    </div>
                                    <select class="form-control select2bs5 get-equipment" id="slctSearchFETLEquipment" name="search_FETL_equipment"></select>    
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">Equipment Model</span>
                                    </div>
                                    <select class="form-control select2bs5 get-equipment-model" id="slctSearchFETLEquipmentModel" name="search_FETL_equipment_model"></select>    
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">From:</span>
                                    </div>
                                    <input type="date" class="form-control" name="from" id="txtSearchFrom" max="<?= date('Y-m-d'); ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">To:</span>
                                    </div>
                                    <input type="date" class="form-control" name="to" id="txtSearchTo" max="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark float-right" id="btnExportTroubleLogs"><i class="fas fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2bs5').select2({
                theme: 'bootstrap-5'
            })          

            GetEquipment($('.get-equipment'))

            $('#slctSearchFETLEquipment').change(function (e) { 
                e.preventDefault();
                let getValue = $(this).val()
                GetEquipmentModel($('.get-equipment-model'),getValue)
            });

            $('#btnExportTroubleLogs').on('click', function(){
                let equipment = $('#slctSearchFETLEquipment').val();
                let equipmentModel = $('#slctSearchFETLEquipmentModel').val();
                let from = $('#txtSearchFrom').val();
                let to = $('#txtSearchTo').val();

                if(equipment == null){
                    console.log('equipment',equipment)
                    alert('Select Equipment');
                }else if(from == ''){
                    console.log('from',from)
                    alert('Select Date From');
                }else if(to == ''){
                    console.log('to',to)
                    alert('Select Date To');
                }else{
                    let encodeEquipment = equipment.replace('/','||')
                    let urlEncodeEquipment = encodeURIComponent(encodeEquipment);
                    let urlEncodeEquipmentmodel;

                    if(equipmentModel != null){
                        let encodeEquipmentModel = equipmentModel.replace('/','||')
                        urlEncodeEquipmentmodel = encodeURIComponent(encodeEquipmentModel);
                    }else{
                        urlEncodeEquipmentmodel = 'null';
                    }

                    window.location.href = `export/${urlEncodeEquipment}/${urlEncodeEquipmentmodel}/${from}/${to}`;
                    console.log('export')
                    $('.alert').remove();
                }
            });
        });
    </script>
@endsection

