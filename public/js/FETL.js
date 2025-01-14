document.querySelectorAll("textarea").forEach(function (size) {
    size.addEventListener("input", function () {
        var resize = window.getComputedStyle(this);
        this.style.height = "auto";
        this.style.height = (this.scrollHeight + parseInt(resize.getPropertyValue("border-top-width")) + parseInt(resize.getPropertyValue("border-bottom-width"))) + "px";
    });
});
function TextareaAutoHeight(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

function GetEquipment(cboElement){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_equipment",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['get_equipment'].length > 0){
                result = '<option value="" selected disabled> Select Equipment </option>';
                for(let index = 0; index < response['get_equipment'].length; index++){
                    result += '<option value="' + response['get_equipment'][index].id+'">'+ response['get_equipment'][index].equipment+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }

    });
}

function GetEquipmentModel(cboElement,getValue){
    let result = '<option value="">N/A</option>';
    $.ajax({
        url: "get_equipment_model",
        method: "get",
        data: {
            getValue: getValue,
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['get_equipment_model'].length > 0){
                result = '<option value="" selected disabled> Select Equipment Model</option>';
                for(let index = 0; index < response['get_equipment_model'].length; index++){
                    result += '<option value="' + response['get_equipment_model'][index].id+'">'+ response['get_equipment_model'][index].equipment_model+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(result);
        }
    });
}

function FETL(){
	$.ajax({
        url: "add_edit_FETL",
        method: "post",
        data: $('#formFETL').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnFETLIcon").addClass('spinner-border spinner-border-sm')
            $("#btnFETL").addClass('disabled')
            $("#iBtnFETLIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['FETL_control_no'] === undefined){
                    $("#txtFETLControlNo").removeClass('is-invalid')
                    $("#txtFETLControlNo").attr('title', '')
                }
                else{
                    $("#txtFETLControlNo").addClass('is-invalid')
                    $("#txtFETLControlNo").attr('title', response['error']['FETL_control_no'])
                }

                if(response['error']['FETL_date'] === undefined){
                    $("#dateFETLDate").removeClass('is-invalid')
                    $("#dateFETLDate").attr('title', '')
                }
                else{
                    $("#dateFETLDate").addClass('is-invalid')
                    $("#dateFETLDate").attr('title', response['error']['FETL_date'])
                }

                if(response['error']['FETL_equipment'] === undefined){
                    $("#slctFETLEquipment").removeClass('is-invalid')
                    $("#slctFETLEquipment").attr('title', '')
                }
                else{
                    $("#slctFETLEquipment").addClass('is-invalid')
                    $("#slctFETLEquipment").attr('title', response['error']['FETL_equipment'])
                }

                if(response['error']['FETL_equipment_model'] === undefined){
                    $("#slctFETLEquipmentModel").removeClass('is-invalid')
                    $("#slctFETLEquipmentModel").attr('title', '')
                }
                else{
                    $("#slctFETLEquipmentModel").addClass('is-invalid')
                    $("#slctFETLEquipmentModel").attr('title', response['error']['FETL_equipment_model'])
                }

                if(response['error']['FETL_parts_needed'] === undefined){
                    $("#txtFETLPartsNeeded").removeClass('is-invalid')
                    $("#txtFETLPartsNeeded").attr('title', '')
                }
                else{
                    $("#txtFETLPartsNeeded").addClass('is-invalid')
                    $("#txtFETLPartsNeeded").attr('title', response['error']['FETL_parts_needed'])
                }

                if(response['error']['FETL_created_by'] === undefined){
                    $("#txtFETLCreatedBy").removeClass('is-invalid')
                    $("#txtFETLCreatedBy").attr('title', '')
                }
                else{
                    $("#txtFETLCreatedBy").addClass('is-invalid')
                    $("#txtFETLCreatedBy").attr('title', response['error']['FETL_created_by'])
                }

                if(response['error']['FETL_noted_by'] === undefined){
                    $("#txtFETLNotedBy").removeClass('is-invalid')
                    $("#txtFETLNotedBy").attr('title', '')
                }
                else{
                    $("#txtFETLNotedBy").addClass('is-invalid')
                    $("#txtFETLNotedBy").attr('title', response['error']['FETL_noted_by'])
                }

                if(response['error']['FETL_checked_by'] === undefined){
                    $("#txtFETLCheckedBy").removeClass('is-invalid')
                    $("#txtFETLCheckedBy").attr('title', '')
                }
                else{
                    $("#txtFETLCheckedBy").addClass('is-invalid')
                    $("#txtFETLCheckedBy").attr('title', response['error']['FETL_checked_by'])
                }

                if(response['error']['FETL_status'] === undefined){
                    $("#txtFETLStatus").removeClass('is-invalid')
                    $("#txtFETLStatus").attr('title', '')
                }
                else{
                    $("#txtFETLStatus").addClass('is-invalid')
                    $("#txtFETLStatus").attr('title', response['error']['FETL_status'])
                }

                if(response['error']['FETL_date_parts_replaced'] === undefined){
                    $("#dateFETLDatePartsReplaced").removeClass('is-invalid')
                    $("#dateFETLDatePartsReplaced").attr('title', '')
                }
                else{
                    $("#dateFETLDatePartsReplaced").addClass('is-invalid')
                    $("#dateFETLDatePartsReplaced").attr('title', response['error']['FETL_date_parts_replaced'])
                }

                if(response['error']['FETL_trouble'] === undefined){
                    $("#txtFETLTrouble").removeClass('is-invalid')
                    $("#txtFETLTrouble").attr('title', '')
                }
                else{
                    $("#txtFETLTrouble").addClass('is-invalid')
                    $("#txtFETLTrouble").attr('title', response['error']['FETL_trouble'])
                }

                if(response['error']['FETL_action_done'] === undefined){
                    $("#txtFETLActionDone").removeClass('is-invalid')
                    $("#txtFETLActionDone").attr('title', '')
                }
                else{
                    $("#txtFETLActionDone").addClass('is-invalid')
                    $("#txtFETLActionDone").attr('title', response['error']['FETL_action_done'])
                }

                if(response['error']['FETL_remark'] === undefined){
                    $("#txtFETLRemark").removeClass('is-invalid')
                    $("#txtFETLRemark").attr('title', '')
                }
                else{
                    $("#txtFETLRemark").addClass('is-invalid')
                    $("#txtFETLRemark").attr('title', response['error']['FETL_remark'])
                }
                
            }else if(response['hasError'] == 0){
                $("#formFETL")[0].reset()
                $('#modalFETL').modal('hide')
                toastr.success('Succesfully saved!')
                dataTableTroubleLogs.draw()
            }else{
                alert('Control No: "'+$("#txtFETLControlNo").val()+'" is already exist!')
            }

            $("#iBtnFETLIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnFETL").removeClass('disabled')
            $("#iBtnFETLIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetFETLByIdToEdit(FETLId){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "get_FETL_info_by_id",
        method: "get",
        data: {
            FETLId: FETLId
        },
        dataType: "json",
        beforeSend: function(){
            GetEquipment($('.get-equipment'))
        },
        success: function(response){
            let FETLInfo = response['FETL_info'];
            let textAreaIds = ['txtFETLTrouble', 'txtFETLActionDone', 'txtFETLRemark']
            console.log('textAreaIds: ', textAreaIds)
            if(FETLInfo.length > 0){
                $('#txtFETLControlNo').val(FETLInfo[0].control_no)
                $("#slctFETLEquipment").val(FETLInfo[0].equipment_id).trigger('change');
                setTimeout(() => {
                    $("#slctFETLEquipmentModel").val(FETLInfo[0].equipment_model_id).trigger('change');
                    // TextareaAutoHeight(document.getElementById('txtFETLTrouble'));
                    // TextareaAutoHeight(document.getElementById('txtFETLActionDone'));
                    // TextareaAutoHeight(document.getElementById('txtFETLRemark'));
                    $('#dateFETLDate').val(FETLInfo[0].date)
                    $('#txtFETLPartsNeeded').val(FETLInfo[0].parts_needed)
                    $('#txtFETLStatus').val(FETLInfo[0].fetls_status)
                    $('#dateFETLDatePartsReplaced').val(FETLInfo[0].date_parts_replaced)
                    $('#txtFETLTrouble').val(FETLInfo[0].trouble)
                    $('#dateFETLDateOfTrouble').val(FETLInfo[0].date_of_trouble)
                    $('#txtFETLLocationOfEquipment').val(FETLInfo[0].location_of_equipment)
                    $('#txtFETLActionDone').val(FETLInfo[0].action_done)
                    $('#txtFETLRemark').val(FETLInfo[0].remark)
                    $('#txtFETLCreatedBy').val(FETLInfo[0].created_by_info.name)
                    $('#txtFETLNotedBy').val(FETLInfo[0].noted_by_info.name)
                    $('#txtFETLCheckedBy').val(FETLInfo[0].checked_by_info.name)
                    for (let index = 0; index < textAreaIds.length; index++) {
                        TextareaAutoHeight(document.getElementById(textAreaIds[index]))                    
                    }
                }, 666);
            }
            else{
                toastr.warning('No Record Found!');
            }
        },

        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function ChangeFETLStatus(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "change_FETL_status",
        method: "post",
        data: $('#formChangeFETLStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeFETLStatusIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnChangeFETLStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Activation failed!');
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeFETLStatus").val() == 1){
                        toastr.success('Activation success!');
                        $("#txtChangeFETLStatus").val() == 2;
                    }
                    else{
                        toastr.success('Deactivation success!');
                        $("#txtChangeFETLStatus").val() == 1;
                    }
                }
                $("#modalChangeFETLStatus").modal('hide');
                $("#formChangeFETLStatus")[0].reset();
                dataTableTroubleLogs.draw();
            }


            $("#iBtnChangeFETLStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeFETLStatus").removeAttr('disabled');
            $("#iBtnChangeFETLStatusIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeFETLStatusIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeFETLStatus").removeAttr('disabled');
            $("#iBtnChangeFETLStatusIcon").addClass('fa fa-check');
        }
    });
}

function ChangeFETLApproval(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "change_FETL_approval",
        method: "post",
        data: $('#formChangeFETLApproval').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#btnChangeFETLApproval").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Activation failed!');
            }else{
                if(response['result'] == 1){
                        toastr.success('Success!');
                }
                $("#modalChangeFETLApproval").modal('hide');
                $("#formChangeFETLApproval")[0].reset();
                dataTableTroubleLogs.draw();
            }

            $("#btnChangeFETLApproval").removeAttr('disabled');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#btnChangeFETLApproval").removeAttr('disabled');
        }
    });
}

function AddFETLDoneBy(){
	$.ajax({
        url: "add_FETL_done_by",
        method: "post",
        data: $('#formFETLDoneBy').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnFETLDoneByIcon").addClass('spinner-border spinner-border-sm')
            $("#btnFETLDoneBy").addClass('disabled')
            $("#iBtnFETLDoneByIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['fetl_user_for_done_by'] === undefined){
                    $("#txtFETLUserForDoneBy").removeClass('is-invalid')
                    $("#txtFETLUserForDoneBy").attr('title', '')
                }
                else{
                    $("#txtFETLUserForDoneBy").addClass('is-invalid')
                    $("#txtFETLUserForDoneBy").attr('title', response['error']['fetl_user_for_done_by'])
                }
                
            }else if(response['hasError'] == 0){
                $("#formFETLDoneBy")[0].reset()
                $('#modalFETLDoneBy').modal('hide')
                toastr.success('Succesfully saved!')
                dataTableTroubleLogs.draw()
            }else{
            }

            $("#iBtnFETLDoneByIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnFETLDoneBy").removeClass('disabled')
            $("#iBtnFETLDoneByIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}