function AddEquipmentModel(){
	$.ajax({
        url: "add_equipment_model",
        method: "post",
        data: $('#formViewEquipmentModel').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnViewEquipmentModelIcon").addClass('spinner-border spinner-border-sm')
            $("#btnViewEquipmentModel").addClass('disabled')
            $("#iBtnViewEquipmentModelIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!')
                
                if(response['error']['equipment_model'] === undefined){
                    $("#txtEquipmentModel").removeClass('is-invalid')
                    $("#txtEquipmentModel").attr('title', '')
                }
                else{
                    $("#txtEquipmentModel").addClass('is-invalid')
                    $("#txtEquipmentModel").attr('title', response['error']['equipment_model'])
                }
                
            }else if(response['hasError'] == 0){
                toastr.success('Succesfully saved!')
                $('#txtEquipmentModel').val('')
                dataTableEquipmentModel.draw()
            }else{
                alert('Equipment Model "'+$("#txtEquipmentModel").val()+'" is already exist!')
            }

            $("#iBtnViewEquipmentModelIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnViewEquipmentModel").removeClass('disabled')
            $("#iBtnViewEquipmentModelIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function EditEquipmentModel(){
	$.ajax({
        url: "edit_equipment_model",
        method: "post",
        data: $('#formEquipmentModel').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEquipmentModelIcon").addClass('spinner-border spinner-border-sm')
            $("#btnEquipmentModel").addClass('disabled')
            $("#iBtnEquipmentModelIcon").removeClass('fa fa-check')
        },
        
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!')
                
                if(response['error']['equipment_model'] === undefined){
                    $("#textEditEquipmentModel").removeClass('is-invalid')
                    $("#textEditEquipmentModel").attr('title', '')
                }
                else{
                    $("#textEditEquipmentModel").addClass('is-invalid')
                    $("#textEditEquipmentModel").attr('title', response['error']['equipment_model'])
                }
                
            }else if(response['hasError'] == 0){
                $("#formEquipmentModel")[0].reset()
                $("#modalEquipmentModel").modal('hide')
                toastr.success('Succesfully saved!')
                dataTableEquipmentModel.draw()
            }else{
                alert('Equipment Model "'+$("#textEditEquipmentModel").val()+'" is already exist!')
            }

            $("#iBtnEquipmentModelIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnEquipmentModel").removeClass('disabled')
            $("#iBtnEquipmentModelIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetEquipmentNameInfoByIdToEdit(viewEquipmentId){
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
    }

    $.ajax({
        url: "get_equipment_name_info_by_id",
        method: "get",
        data: {
            viewEquipmentId: viewEquipmentId,
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let equipmentNameInfo = response['equipment_name_info']

            if(equipmentNameInfo.length > 0){
                $("#txtViewEquipment").val(equipmentNameInfo[0].equipment)
            }
            else{
                toastr.warning('No Record Found!')
            }
        },

        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetEquipmentModelInfoByIdToEdit(equipmentModelId){
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
    }

    $.ajax({
        url: "get_equipment_model_info_by_id",
        method: "get",
        data: {
            equipmentModelId: equipmentModelId,
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let equipmentModelInfo = response['equipment_model_info']

            if(equipmentModelInfo.length > 0){
                $("#textEditEquipmentModel").val(equipmentModelInfo[0].equipment_model)
            }
            else{
                toastr.warning('No Record Found!')
            }
        },

        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function ChangeEquipmentModelStatus(){
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
    }

    $.ajax({
        url: "change_equipment_model_status",
        method: "post",
        data: $('#formChangeEquipmentModelStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentModelStatus").prop('disabled', 'disabled')
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Successfully Failed!')
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeEquipmentModelStatus").val() == 1){
                        toastr.success('Equipment Model activation success!')
                        $("#txtChangeEquipmentModelStatus").val() == 2
                    }
                    else{
                        toastr.success('Equipment Model deactivation success!')
                        $("#txtChangeEquipmentModelStatus").val() == 1
                    }
                }
                $("#formChangeEquipmentModelStatus")[0].reset()
                $("#modalChangeEquipmentModelStatus").modal('hide')
                dataTableEquipmentModel.draw()
            }

            $("#iBtnChangeEquipmentModelStatusIcon").removeClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentModelStatus").removeAttr('disabled')
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
            $("#iBtnChangeEquipmentModelStatusIcon").removeClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentModelStatus").removeAttr('disabled')
            $("#iBtnChangeEquipmentModelStatusIcon").addClass('fa fa-check')
        }
    })
}