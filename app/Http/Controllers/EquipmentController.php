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

use App\Models\User;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    
    public function viewEquipments(){
        $equipment_details = Equipment::where('logdel', 0)->orderBy('equipment', 'ASC')->get();
        
        return DataTables::of($equipment_details)
        ->addColumn('action', function($equipment_detail){
            $result = '<center>';
            
            if($equipment_detail->status == 1){
                $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionEditEquipment mr-2" equipment-id="' . $equipment_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalEquipment" title="Edit Equipment Details"><i class="fa fa-xl fa-edit"></i></button>';
                $result .= '<button type="button" class="btn btn-info btn-sm text-center actionViewEquipmentModel mr-2" equipment-id="' . $equipment_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalViewEquipmentModel" title="View Equipment Model"><i class="fa fa-xl fa-eye"></i></button>';
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeEquipmentStatus mr-2" equipment-id="' . $equipment_detail->id . '" status="2" data-bs-toggle="modal" data-bs-target="#modalChangeEquipmentStatus" title="Deactivate Equipment"><i class="fa-solid fa-xl fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeEquipmentStatus mr-2" equipment-id="' . $equipment_detail->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalChangeEquipmentStatus" title="Activate Equipment"><i class="fa-solid fa-xl fa-arrow-rotate-right"></i></button>';
            }
            
            $result .= '</center>';
            return $result;
        })


        ->addColumn('status', function($equipment_detail){
            $result = "";
            if($equipment_detail->status == 1){
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

    public function addEditEquipment(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'equipment'   => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $check_existing_record = Equipment::where('equipment', $request->equipment)->get();
                if($request->equipment_id != ''){
                    if( count($check_existing_record) != 1){
                        Equipment::where('id', $request->equipment_id)->update([
                            'equipment'    => $request->equipment,
                            'updated_at'        => date('Y-m-d H:i:s'),
                        ]);
                    }else{
                        return response()->json(['result' => 1]);
                    }
                }else{
                    if( count($check_existing_record) != 1){
                        Equipment::insert([
                            'equipment'    => $request->equipment,
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

    public function getEquipmentInfoById(Request $request){
        $equipment_info = Equipment::where('id', $request->equipmentId)->get();
        // return $equipment_info[0]->rapidx_user_info->id;
        return response()->json([
            'equipment_info' => $equipment_info, 
        ]);
    }

    
    //============================== CHANGE EQUIPMENT STAT ==============================
    public function changeEquipmentStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'equipment_id'  => 'required',
            'status'        => 'required',
        ]);

        if($validator->passes()){
            Equipment::where('id', $request->equipment_id)
            ->update([
                'status' => $request->status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['result' => "1"]);
        }
        else{
            return response()->json(['validation' => "hasError", 'error' => $validator->messages()]);
        }
    }
}
