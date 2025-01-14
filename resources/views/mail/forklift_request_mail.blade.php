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
                                    @if(in_array($status, [2,3]))
                                        <label style="font-size: 18px;">Please be informed that you have Facility Equipment Trouble Logs for approval as of today {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif

                                    @if (in_array($status, [4,5]))
                                        <label style="font-size: 18px;">Please be notified that your Facility Equipment Trouble Logs has been disapproved. {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif

                                    @if ($status == 3)
                                        <label style="font-size: 18px;">Please be notified that your Facility Equipment Trouble Logs has been approved. {{ \Carbon\Carbon::now()->toFormattedDateString() }} {{ \Carbon\Carbon::now()->isoFormat('LT') }}</label>
                                    @endif
                                    <br><br>
                                    <hr>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>Trouble Details: </strong></label>
                                    </div>
                                </div>

                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>REQUEST NO.: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->request_no }} </span>
                                            @else
                                                <span class="text-black">{{ $data['request_no'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>REQUESTED BY: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->forklift_request_approver_info->requestor_approver_info->name }} </span>
                                            @else
                                                <span class="text-black">{{ $name }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>DEPARTMENT: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->department }} </span>
                                            @else
                                                <span class="text-black">{{ $data['department'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>DATE NEEDED: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->date_needed }}</span>
                                            @else
                                                <span class="text-black">{{ $data['date_needed'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>TIME START: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->time }} </span>
                                            @else
                                                <span class="text-black">{{ $data['time_start'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>PICK-UP FROM: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->pick_up_from }}</span>
                                            @else
                                                <span class="text-black">{{ $data['pickup_from'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>DELIVERY TO: .</strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->delivery_to }} </span>
                                            @else
                                                <span class="text-black">{{ $data['delivery_to'] }} </span>
                                            @endif
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>PACKAGE/COMMODITY: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->package_commodity }}</span>                                            
                                            @else
                                                <span class="text-black">{{ $data['package_commodity'] }} </span>
                                            @endif                                            
                                        </label>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><strong>VOLUME OF TRIPS: </strong>
                                            @if ($count != 0)
                                                <span class="text-black">{{ $data[0]->volume_of_trips }}</span>
                                            @else
                                                <span class="text-black">{{ $data['volume_of_trips'] }} </span>
                                            @endif                                            
                                        </label>
                                    </div>
                                </div>

                                <br>
                                <br>
                                
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">Please login your Rapidx account to get more information. Locate the Facility Equipment Trouble Logs System at http://rapidx/. </label>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label"><b> Notice of Disclaimer: </b></label>
                                        <br>
                                        <label class="col-sm-12 col-form-label"></label>   This message contains confidential information intended for a specific individual and purpose. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.</label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br><br>
                                    <label style="font-size: 18px;"><b>For concerns on using the form, please contact ISS at local numbers 205, 206, or 208. You may send us e-mail at <a href="mailto: servicerequest@pricon.ph">servicerequest@pricon.ph</a></b></label>
                                </div>
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