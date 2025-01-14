<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style type="text/css">
            body{
                font-family: Arial;
                font-size: 15px;
            }

            .text-green{
                color: green;
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <div class="row">
            <div class="col-sm-12">
                <div class="row" style="margin: 1px 10px;">
                    <div class="col-sm-12">
                        <form id="frmSaveRecord">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label style="font-size: 18px;">Good day!</label><br>
                                    @if(in_array($status, [1,2]))
                                        <label style="font-size: 18px;">Please be informed that you have Facility Equipment Trouble Logs for approval as of today {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif

                                    @if (in_array($status, [4,5]))
                                        <label style="font-size: 18px;">Please be notified that your Facility Equipment Trouble Logs has been disapproved. {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif

                                    @if ($status == 3)
                                        <label style="font-size: 18px;">Please be notified that your Facility Equipment Trouble Logs has been approved. {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif
                                    <br><br><hr>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label><strong>TROUBLE DETAILS: </strong></label>
                                    </div>
                                </div><br>

                                <div class="form-group row">
                                    <label><strong>CONTROL NO.: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->control_no }} </span><br><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_control_no'] }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>EQUIPMENT: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->trouble_logs_equipment_info->equipment }} </span><br><br>
                                    @else
                                    <span class="text-black">{{ $equipments[0]->trouble_logs_equipment_info->equipment }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>EQUIPMENT MODEL: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->trouble_logs_equipment_model_info->equipment_model }} </span><br><br>
                                    @else
                                    <span class="text-black">{{ $equipments[0]->trouble_logs_equipment_model_info->equipment_model }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>TROUBLE: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->trouble }} </span><br><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_trouble'] }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>DATE: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->date }}</span><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_date'] }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>PARTS NEEDED: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->parts_needed }} </span><br><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_parts_needed'] }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>ACTION DONE: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->action_done }}</span><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_action_done'] }} </span><br><br>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label><strong>DATE PARTS REPLACE: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->date_parts_replaced }}</span><br>                                            
                                    @else
                                        <span class="text-black">{{ $data['FETL_date_parts_replaced'] }} </span><br><br>
                                    @endif                                            
                                </div>

                                <div class="form-group row">
                                    <label><strong>REMARKS: </strong></label><br>
                                    @if ($count != 0)
                                        <span class="text-black">{{ $data[0]->remark }}</span><br>
                                    @else
                                        <span class="text-black">{{ $data['FETL_remark'] }} </span><br><br>
                                    @endif                                            
                                </div><br><br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label>Please login your Rapidx account to get more information. Locate the Facility Equipment Trouble Logs System at http://rapidx/. </label>
                                    </div>
                                </div><br><br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label><b> Notice of Disclaimer: </b></label>
                                        <br>
                                        <label></label>   This message contains confidential information intended for a specific individual and purpose. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.</label>
                                    </div>
                                </div><br><br>

                                <div class="col-sm-12">
                                    <label style="font-size: 18px;"><b>For concerns on using the form, please contact ISS at local numbers 205, 206, or 208. You may send us e-mail at <a href="mailto: servicerequest@pricon.ph">servicerequest@pricon.ph</a></b></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </body>
</html>