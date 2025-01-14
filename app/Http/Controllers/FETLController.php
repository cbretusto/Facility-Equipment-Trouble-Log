<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

use Auth; // or use Illuminate\Support\Facades\Auth;
use Mail;
use DataTables;

use App\Models\User;
use App\Models\FETL;
use App\Models\Equipment;
use App\Models\RapidXUser;
use App\Models\EquipmentModel;


class FETLController extends Controller
{
    public function viewTroubleLogsApproval(Request $request){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];

        switch ($request->category) {
            case '0':
                $where_in = '1,2';
                break;
            case '1':
                $where_in = '3';
                break;
            case '2':
                $where_in = '4,5';
                break;
            
            default:
                $where_in = '6';
                break;
        }

        $trouble_logs_details = FETL::with([
            'trouble_logs_equipment_info',
            'trouble_logs_equipment_model_info',
            'created_by_info',
            'noted_by_info',
            'checked_by_info'
        ])
        ->where('logdel', 0)
        ->whereIn('approval_status', [$where_in])
        ->orWhere('created_by', $rapidx_user_id)
        ->orWhere('noted_by', $rapidx_user_id)
        ->orWhere('checked_by', $rapidx_user_id)
        ->orderBy('id', 'DESC')
        ->get();

        return DataTables::of($trouble_logs_details)
        ->addColumn('action', function($trouble_logs_detail) use($rapidx_user_id){
            $result = '<center>';
            $result .= '<button type="button" class="btn btn-info btn-xs actionViewFETL mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalFETL" title="View Trouble Logs"><i class="fa fa-xl fa-eye"></i></button><br>';
                if($trouble_logs_detail->created_by == $rapidx_user_id){
                    if($trouble_logs_detail->status == 1){
                        $result .= '<button type="button" class="btn btn-dark btn-xs actionEditFETL mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalFETL" title="Edit Trouble Logs"><i class="fa fa-xl fa-edit"></i></button><br>';
                        $result .= '<button type="button" class="btn btn-danger btn-xs actionChangeFETLStatus mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="2" data-bs-toggle="modal" data-bs-target="#modalChangeFETLStatus" title="Deactivate Trouble Logs"><i class="fa-solid fa-xl fa-ban"></i></button><br>';
                    }else{
                        $result .= '<button type="button" class="btn btn-warning btn-xs actionChangeFETLStatus mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalChangeFETLStatus" title="Activate Trouble Logs"><i class="fa-solid fa-xl fa-arrow-rotate-right"></i></button><br>';
                    }
                }
    
                if($trouble_logs_detail->noted_by == $rapidx_user_id){
                    if($trouble_logs_detail->approval_status == 1){
                        $result .= '<button type="button" class="btn btn-success btn-xs actionChangeFETLApproval mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="2"  data-bs-toggle="modal" data-bs-target="#modalChangeFETLApproval" title="Approve"><i class="fa fa-xl fa-thumbs-up"></i></button>';
                        $result .= '<button type="button" class="btn btn-danger btn-xs actionChangeFETLApproval mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="4" data-bs-toggle="modal" data-bs-target="#modalChangeFETLApproval" title="Disaprove"><i class="fa fa-xl fa-thumbs-down"></i></button>';
                    }
                }
    
                if($trouble_logs_detail->checked_by == $rapidx_user_id){
                    if($trouble_logs_detail->approval_status == 2){
                        $result .= '<button type="button" class="btn btn-success btn-xs actionChangeFETLApproval mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="3" data-bs-toggle="modal" data-bs-target="#modalChangeFETLApproval" title="Approve"><i class="fa fa-xl fa-thumbs-up"></i></button>';
                        $result .= '<button type="button" class="btn btn-danger btn-xs actionChangeFETLApproval mb-2 mr-2" FETL-id="' . $trouble_logs_detail->id . '" status="5" data-bs-toggle="modal" data-bs-target="#modalChangeFETLApproval" title="Disaprove"><i class="fa fa-xl fa-thumbs-down"></i></button>';
                    }
                }

                if($trouble_logs_detail->approval_status == 3 && $trouble_logs_detail->done_by == null){
                    $result .= '<button type="button" class="btn btn-warning btn-xs actionFETLDoneBy mb-2 mr-2 w-100" FETL-id="' . $trouble_logs_detail->id . '" status="2"  data-bs-toggle="modal" data-bs-target="#modalFETLDoneBy" title="Done By:"><strong>Done By</strong></button>';
                }

            $result .= '</center>';
            return $result;
        })

        ->addColumn('approval_status', function($trouble_logs_detail){
            $result = '<center>';
            $noted_by_time_remark = explode(' ',$trouble_logs_detail->noted_by_time_remark);
            $checked_by_time_remark = explode(' ',$trouble_logs_detail->checked_by_time_remark);

            switch ($trouble_logs_detail->approval_status)
            {
                case 1:{
                    $result .= '<span class="badge badge-warning">Approval of Noted By: <br>'.$trouble_logs_detail->noted_by_info->name .' </span><br>';
                    $result .= '<span class="badge badge-info">Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .' </span><br>';
                    break;
                }

                case 2:{
                    $result .= '<span class="badge badge-light shadow mb-2">'. $noted_by_time_remark[0] .' <br> Noted By: <br>'. $trouble_logs_detail->noted_by_info->name .'</span><br>';
                    $result .= '<span class="badge badge-warning">Approval of Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .' </span><br>';
                    break;
                }

                case 3:{
                    $result .= '<span class="badge badge-light shadow mb-2">'. $noted_by_time_remark[0] .' <br> Noted By: <br>'. $trouble_logs_detail->noted_by_info->name .'</span><br>';
                    $result .= '<span class="badge badge-light shadow mb-2">'. $checked_by_time_remark[0] .' <br> Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .'</span><br>';                    
                    break;
                }

                case 4:{
                    $result .= '<span class="badge badge-danger">'. $noted_by_time_remark[0] .' <br> Noted By: <br>'. $trouble_logs_detail->noted_by_info->name .'</span><br>';
                    $result .= '<span class="badge badge-light">Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .'</span><br>';
                    break;
                }

                case 5:{
                    $result .= '<span class="badge badge-light shadow mb-2">'. $noted_by_time_remark[0] .' <br> Noted By: <br>'. $trouble_logs_detail->noted_by_info->name .'</span><br>';
                    $result .= '<span class="badge badge-danger">'. $checked_by_time_remark[0] .' <br> Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .'</span><br>';
                    break;
                }

                default:
                $result .= '<span class="badge badge-light shadow mb-2">'. $noted_by_time_remark[0] .' <br> Noted By: <br>'. $trouble_logs_detail->noted_by_info->name .'</span><br>';
                $result .= '<span class="badge badge-light shadow mb-2">'. $checked_by_time_remark[0] .' <br> Checked By: <br>'.$trouble_logs_detail->checked_by_info->name .'</span><br>';
                
                if($trouble_logs_detail->done_by != null){
                    $updated_at = explode(' ',$trouble_logs_detail->updated_at);
                    $result .= '<span class="badge badge-light shadow mb-2">'. $updated_at[0] .' <br> Done By: <br>'.$trouble_logs_detail->done_by .'</span><br>';
                }
        }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns(['action','approval_status'])
        ->make(true);
    }

    public function getEquipment(Request $request){
        $get_equipment = Equipment::where('status', 1)->where('logdel', 0)->orderBy('equipment', 'ASC')->get();
        return response()->json(['get_equipment'  => $get_equipment]);
    }

    public function getEquipmentModel(Request $request){
        $get_equipment_model = EquipmentModel::where('equipment_id', $request->getValue)->where('status', 1)->where('logdel', 0)->orderBy('equipment_model', 'ASC')->get();
        return response()->json(['get_equipment_model'  => $get_equipment_model]);
    }

    public function newControlNo(Request $request){
        $get_user = User::with(['rapidx_user_info'])->whereNotNull('classification')->where('status', 1)->where('logdel', 0)->get();
        $new_control_number = FETL::where('status', 1)->where('logdel', 0)->orderBy('id', 'DESC')->first();
        $control_no_format = "FETL-".NOW()->format('ymd')."-";

        if ($new_control_number == null){
            $new_control_no = $control_no_format.'1';
        }else{
            $explode_control_no = explode("-",  $new_control_number->control_no);
            $get = $explode_control_no[2]+1;
            $new_control_no = $control_no_format.$get;
        }

        return response()->json(['new_control_number'  => $new_control_no, 'get_user' => $get_user]);
    }

    public function addEditFETL(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'FETL_control_no'       => 'required',
            'FETL_date'             => 'required',
            'FETL_equipment'        => 'required',
            'FETL_equipment_model'  => 'required',
            'FETL_parts_needed'     => 'required',
            'FETL_created_by'       => 'required',
            'FETL_noted_by'         => 'required',
            'FETL_checked_by'       => 'required',
            'FETL_trouble'          => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $check_existing_record = FETL::where('control_no', $request->FETL_control_no)->where('logdel', 0)->get();
                $get_created_by = RapidXUser::where('name', $request->FETL_created_by)->get();
                $get_noted_by = RapidXUser::where('name', $request->FETL_noted_by)->get();
                $get_checked_by = RapidXUser::where('name', $request->FETL_checked_by)->get();
                if($request->FETL_id != ''){
                    FETL::where('id', $request->FETL_id)->update([
                        'equipment_id'          => $request->FETL_equipment,
                        'equipment_model_id'    => $request->FETL_equipment_model,
                        'trouble'               => $request->FETL_trouble,
                        'parts_needed'          => $request->FETL_parts_needed,
                        'action_done'           => $request->FETL_action_done,
                        'fetls_status'          => $request->FETL_status,
                        'date_parts_replaced'   => $request->FETL_date_parts_replaced,
                        'location_of_equipment' => $request->FETL_location_of_equipment,
                        'date_of_trouble'       => $request->FETL_date_of_trouble,
                        'done_by'               => null,
                        'approval_status'       => 1,
                        'remark'                => $request->FETL_remark,
                        'noted_by'              => $get_noted_by[0]->id,
                        'checked_by'            => $get_checked_by[0]->id,
                        'updated_at'            => date('Y-m-d H:i:s'),
                    ]);
                }else{
                    if( count($check_existing_record) != 1){
                        FETL::insert([
                            'control_no'            => $request->FETL_control_no,
                            'equipment_id'          => $request->FETL_equipment,
                            'equipment_model_id'    => $request->FETL_equipment_model,
                            'trouble'               => $request->FETL_trouble,
                            'date'                  => $request->FETL_date,
                            'parts_needed'          => $request->FETL_parts_needed,
                            'action_done'           => $request->FETL_action_done,
                            'fetls_status'          => $request->FETL_status,
                            'date_parts_replaced'   => $request->FETL_date_parts_replaced,
                            'location_of_equipment' => $request->FETL_location_of_equipment,
                            'date_of_trouble'       => $request->FETL_date_of_trouble,    
                            'remark'                => $request->FETL_remark,
                            'created_by'            => $get_created_by[0]->id,
                            'noted_by'              => $get_noted_by[0]->id,
                            'checked_by'            => $get_checked_by[0]->id,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ]);    
                    }else{
                        return response()->json(['result' => 1]);
                    }
                }

                $equipments = FETL::with(
                    'trouble_logs_equipment_info',
                    'trouble_logs_equipment_model_info'
                )
                ->where('equipment_id',$request->FETL_equipment)
                ->where('equipment_model_id',$request->FETL_equipment_model)
                ->get();

                $get_data = ['data' => $request, 'status' => 1, 'equipments' => $equipments, 'count' => 0];
                $send_email_to = $get_noted_by[0]->email;
                $send_email_cc = $get_created_by[0]->email;

                Mail::send('mail.FETL_mail', $get_data, function($message) use($send_email_to, $send_email_cc){
                    $message->to($send_email_to)->cc($send_email_cc)->bcc('cbretusto@pricon.ph')->subject('For Approval: Facility Equipment Trouble Logs');
                });
                
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            }
        }
    }

    public function getFETLInfoById(Request $request){
        $FETL_info = FETL::with(['trouble_logs_equipment_info','trouble_logs_equipment_model_info','created_by_info','noted_by_info','checked_by_info'])->where('id', $request->FETLId)->get();

        return response()->json([
            'FETL_info' => $FETL_info, 
        ]);
    }

    //============================== CHANGE FETL STATUS ==============================
    public function changeFETLStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'status_FETL_id'    => 'required',
            'status'            => 'required',
        ]);

        if($validator->passes()){
            FETL::where('id', $request->status_FETL_id)
            ->update([
                'status'        => $request->status,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }
    
    //============================== CHANGE FETL APPROVAL ==============================
    public function changeFETLApproval(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'approval_FETL_id' => 'required',
            'approval_status' => 'required',
        ]);
        
        if($request->approval_status == 2 || $request->approval_status == 4){
            $approval_time = 'noted_by_time_remark';
        }else{
            $approval_time = 'checked_by_time_remark';
        }
        if($validator->passes()){
            FETL::where('id', $request->approval_FETL_id)
            ->update([
                'approval_status' => $request->approval_status,
                $approval_time => date('Y-m-d H:i:s'),
            ]);

            $equipments = FETL::with(
                'trouble_logs_equipment_info',
                'trouble_logs_equipment_model_info',
                'created_by_info',
                'checked_by_info'
            )
            ->where('id', $request->approval_FETL_id)
            ->get();

            $get_data = ['data' => $equipments, 'status' => $request->approval_status, 'count' => 1];
            $send_email_to = $equipments[0]->checked_by_info->email;
            $send_email_cc = $equipments[0]->created_by_info->email;

            switch ($request->approval_status)
            {
                case 2:{
                    $subject = 'For Approval: Facility Equipment Trouble Logs';
                    break;
                }

                case 3:{
                    $subject = 'Approved: Facility Equipment Trouble Logs';
                    break;
                }

                case 4:{
                    $subject = 'Disapproved: Facility Equipment Trouble Logs';
                    break;
                }
                
                default:
                $subject = 'Disapproved: Facility Equipment Trouble Logs';
            }

            Mail::send('mail.FETL_mail', $get_data, function($message) use($send_email_to, $send_email_cc, $subject){
                $message->to($send_email_to)->cc($send_email_cc)->bcc('cbretusto@pricon.ph')->subject($subject);
            });

            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

        //============================== DONE BY ==============================
        public function addFETLDoneBy(Request $request){        
            date_default_timezone_set('Asia/Manila');
    
            $data = $request->all(); // collect all input fields
    
            $validator = Validator::make($data, [
                'fetl_id_for_done_by'   => 'required',
                'fetl_user_for_done_by' => 'required',
            ]);

            if($validator->passes()){
                FETL::where('id', $request->fetl_id_for_done_by)
                ->update([
                    'done_by'       => $request->fetl_user_for_done_by,
                    'status'        => '6',
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                return response()->json(['hasError' => "0"]);
            }
            else{
                return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
            }
        }

}
