function Equipments(){
	$.ajax({
        url: "add_edit_equipment",
        method: "post",
        data: $('#formEquipment').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnEquipmentIcon").addClass('spinner-border spinner-border-sm')
            $("#btnEquipment").addClass('disabled')
            $("#iBtnEquipmentIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!')

                if(response['error']['equipment'] === undefined){
                    $("#textEquipment").removeClass('is-invalid')
                    $("#textEquipment").attr('title', '')
                }
                else{
                    $("#textEquipment").addClass('is-invalid')
                    $("#textEquipment").attr('title', response['error']['equipment'])
                }
                
            }else if(response['hasError'] == 0){
                $("#formEquipment")[0].reset()
                $('#modalEquipment').modal('hide')
                toastr.success('Succesfully saved!')
                dataTableEquipment.draw()
            }else{
                alert('Equipment Name "'+$("#textEquipment").val()+'" is already exist!')
            }

            $("#iBtnEquipmentIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnEquipment").removeClass('disabled')
            $("#iBtnEquipmentIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetEquipmentInfoByIdToEdit(equipmentId){
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
        url: "get_equipment_info_by_id",
        method: "get",
        data: {
            equipmentId: equipmentId
        },
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let equipmentInfo = response['equipment_info']

            if(equipmentInfo.length > 0){
                $("#textEquipment").val(equipmentInfo[0].equipment)
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

function ChangeEquipmentStatus(){
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
        url: "change_equipment_status",
        method: "post",
        data: $('#formChangeEquipmentStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnChangeEquipmentStatusIcon").addClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentStatus").prop('disabled', 'disabled')
        },
        success: function(response){

            if(response['validation'] == 'hasError'){
                toastr.error('Successfully Failed!')
            }else{
                if(response['result'] == 1){
                    if($("#txtChangeEquipmentStatus").val() == 1){
                        toastr.success('Equipment activation success!')
                        $("#txtChangeEquipmentStatus").val() == 2
                    }
                    else{
                        toastr.success('Equipment deactivation success!')
                        $("#txtChangeEquipmentStatus").val() == 1
                    }
                }
                $("#modalChangeEquipmentStatus").modal('hide')
                $("#formChangeEquipmentStatus")[0].reset()
                dataTableEquipment.draw()
            }

            $("#iBtnChangeEquipmentStatusIcon").removeClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentStatus").removeAttr('disabled')
            $("#iBtnChangeEquipmentStatusIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
            $("#iBtnChangeEquipmentStatusIcon").removeClass('fa fa-spinner fa-pulse')
            $("#btnChangeEquipmentStatus").removeAttr('disabled')
            $("#iBtnChangeEquipmentStatusIcon").addClass('fa fa-check')
        }
    })
}