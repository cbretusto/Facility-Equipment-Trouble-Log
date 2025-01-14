<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

use Auth; // or use Illuminate\Support\Facades\Auth;
use DataTables;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\RapidXUser;
use App\Models\SystemOneHRIS;
use App\Models\SystemOneSubcon;
use App\Models\SystemOneDepartment;
use App\Models\SystemOneSection;

class UserController extends Controller
{
    public function viewUsers(){
        $userDetails = User::with(['rapidx_user_info'])->where('logdel', 0)->get();
        
        return DataTables::of($userDetails)
        ->addColumn('action', function($userDetail){
            $result =   '<center>';
            
            if($userDetail->status == 1){
                $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionEditUser mr-1" user-id="' . $userDetail->id . '" data-bs-toggle="modal" data-bs-target="#modalUser" title="Edit User Details"><i class="fa fa-xl fa-edit"></i></button>';
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeUserStat mr-1" user-id="' . $userDetail->id . '" status="2" data-bs-toggle="modal" data-bs-target="#modalChangeUserStat" title="Deactivate User"><i class="fa-solid fa-xl fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeUserStat mr-1" user-id="' . $userDetail->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalChangeUserStat" title="Activate User"><i class="fa-solid fa-xl fa-arrow-rotate-right"></i></button>';
            }
            
            $result .= '</center>';
            return $result;
        })


        ->addColumn('status', function($userDetail){
            $result = "";
            if($userDetail->status == 1){
                $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
            }
            else{
                $result .= '<center><span class="badge badge-pill badge-danger">Inactive</span></center>';
            }
            return $result;
        })


        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function getEmployeeName(){
        $get_employee_name = RapidXUser::where('user_stat', 1)->where('department_id', '30')->orderBy('employee_number', 'DESC')->whereNotNull('employee_number')->get();
        return response()->json(['get_employee_name' => $get_employee_name]);
    }

    public function getEmployeeInfo(Request $request){
        $rapidx_employee_id = RapidXUser::where('id', $request->emp_id)->where('department_id', '30')->get();
        $pmi_employee = SystemOneHRIS::with(['position_info', 'section_info'])->where('EmpNo', $rapidx_employee_id[0]->employee_number)->where('EmpStatus', 1)->get();
        $subcon_employee = SystemOneSubcon::with(['position_info', 'section_info'])->where('EmpNo', $rapidx_employee_id[0]->employee_number)->where('EmpStatus', 1)->where('logdel', 0)->get();
        $result = $pmi_employee->toBase()->merge($subcon_employee);

        if(count($result) > 0){
            return response()->json(['rapidx_employee_id' => $rapidx_employee_id, 'result' => $result]);
        }else{
            return response()->json(['result' => 'no_data']);
        }
    }

    public function addEditUser(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'employee_name'   => 'required',
            'username'      => 'required',
            'position'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $check_existing_record = User::where('rapidx_user_id', $request->employee_name)->get();
                if($request->user_id != ''){
                    if( count($check_existing_record) != 1){
                        User::where('id', $request->user_id)->update([
                            'rapidx_user_id'    => $request->employee_name,
                            'position'          => $request->position,
                            'updated_at'        => date('Y-m-d H:i:s'),
                        ]);
                    }else{
                        return response()->json(['result' => 1]);
                    }
                }else{
                    if( count($check_existing_record) != 1){
                        User::insert([
                            'rapidx_user_id'    => $request->employee_name,
                            'position'          => $request->position,
                            'created_at'        => date('Y-m-d H:i:s'),
                        ]);    
                    }else{
                        return response()->json(['result' => 1]);
                    }
                }
                
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            }
        }
    }

    public function getUserInfoById(Request $request){
        $user_info = User::with(['rapidx_user_info'])->where('id', $request->UserId)->get();
        // return $user_info[0]->rapidx_user_info->id;
        return response()->json([
            'user_info' => $user_info, 
        ]);
    }

    //============================== CHANGE USER STAT ==============================
    public function changeUserStat(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            User::where('id', $request->user_id)
            ->update([
                'status' => $request->status,
                'classification' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function viewApproverList(){
        $approverDetails = User::with(['rapidx_user_info'])->whereNotNull('classification')->orderBy('classification', 'ASC')->where('status', 1)->where('logdel', 0)->get();
        
        return DataTables::of($approverDetails)
        ->addColumn('action', function($approverDetail){
            // $result =   '<center>';
            $result = '<button type="button" class="btn btn-danger btn-sm text-center actionRemoveClassification mr-1" user-id="' . $approverDetail->id . '" data-bs-toggle="modal" data-bs-target="#modalRemoveApproverClassification" title="Remove Approver"><i class="fa-solid fa-ban"></i> Remove Approver</button>';
            // $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($approverDetail){
            $result = "";
            if($approverDetail->status == 1){
                $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
            }
            else{
                $result .= '<center><span class="badge badge-pill badge-danger">Inactive</span></center>';
            }
            return $result;
        })

        ->rawColumns(['action','status', 'name'])
        ->make(true);
    }

    public function getApproverName(){
        $get_approver_name = User::with(['rapidx_user_info'])->where('status', 1)->where('logdel', 0)->get();
        return response()->json(['get_approver_name' => $get_approver_name]);
    }

    public function addEditApprover(Request $request){
        date_default_timezone_set('Asia/Manila');

        session_start();
        $data = $request->all();
        $validator = Validator::make($data, [
            'approver_employee_name'    => 'required',
            'classification'            => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if(User::where('classification', $request->classification)->where('logdel', 0)->where('status', 1)->doesntExist()){
                    User::where('rapidx_user_id', $request->approver_employee_name)->update([
                        'classification'    => $request->classification,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                    $result = 1;
                }else{
                    $result = 2;
                }
                DB::commit();
                return response()->json(['hasError' => $result]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 0, 'exceptionError' => $e]);
            }
        }
    }

    public function getUserApproverInfoById(Request $request){
        $user_approver_info = User::with(['rapidx_user_info'])->where('id', $request->approverId)->get();

        return response()->json([
            'user_approver_info' => $user_approver_info, 
        ]);
    }

    //============================== REMOVE APPROVER ==============================
    public function removeApproverStat(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'approver_user_id' => 'required',
        ]);

        if($validator->passes()){
            User::where('id', $request->approver_user_id)
            ->update([
                'classification' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }

    public function getUserLog(Request $request){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];
        $rapidx_department_id = $_SESSION['rapidx_department_id'];
        // return $rapidx_user_id;
        $user_log = User::with(['rapidx_user_info'])
            ->where('rapidx_user_id', $request->loginEmployeeId)
            ->where('status', 1)
            ->where('logdel', 0)
            ->get();
        return response()->json(['result' => $user_log, 'rapidxDepartmentId' => $rapidx_department_id]);
    }
}
