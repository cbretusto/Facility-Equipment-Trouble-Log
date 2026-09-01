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
use App\Models\EquipmentModel;

class EquipmentModelController extends Controller
{
    public function viewEquipmentModel(Request $request){
        $equipment_model_details = EquipmentModel::where('equipment_id', $request->viewEquipmentId)->where('logdel', 0)->orderBy('equipment_model', 'ASC')->get();
        
        return DataTables::of($equipment_model_details)
        ->addColumn('action', function($equipment_model_detail){
            $result = '<center>';
            
            if($equipment_model_detail->status == 1){
                $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionEditEquipmentModel mr-2" equipment_model-id="' . $equipment_model_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalEquipmentModel" title="Edit Equipment Model"><i class="fa fa-xl fa-edit"></i></button>';
                $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeEquipmentModelStatus mr-2" equipment_model-id="' . $equipment_model_detail->id . '" status="2" data-bs-toggle="modal" data-bs-target="#modalChangeEquipmentModelStatus" title="Deactivate Equipment Model"><i class="fa-solid fa-xl fa-ban"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeEquipmentModelStatus mr-2" equipment_model-id="' . $equipment_model_detail->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalChangeEquipmentModelStatus" title="Activate Equipment Model"><i class="fa-solid fa-xl fa-arrow-rotate-right"></i></button>';
            }
            
            $result .= '</center>';
            return $result;
        })


        ->addColumn('status', function($equipment_model_detail){
            $result = "";
            if($equipment_model_detail->status == 1){
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

    public function addEquipmentModel(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'view_equipment_id' => 'required',
            'view_equipment'    => 'required',
            'equipment_model'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            // DB::beginTransaction();
            // try {
                $check_existing_record = EquipmentModel::where('equipment_model', $request->equipment_model)->get();
                if( count($check_existing_record) != 1){
                    EquipmentModel::insert([
                        'equipment_id'      => $request->view_equipment_id,
                        'equipment_model'   => $request->equipment_model,
                        'created_at'        => date('Y-m-d H:i:s'),
                    ]);    
                }else{
                    return response()->json(['result' => 1]);
                }
                
                DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            // }
        }
    }

    public function editEquipmentModel(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [
            'equipment_model_id' => 'required',
            'equipment_model'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $check_existing_record = EquipmentModel::where('equipment_model', $request->equipment_model)->get();
                if( count($check_existing_record) != 1){
                    EquipmentModel::where('id', $request->equipment_model_id)->update([
                        'equipment_model'   => $request->equipment_model,
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);    
                }else{
                    return response()->json(['result' => 1]);
                }
                
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            }
        }
    }

    public function getEquipmentNameInfoById(Request $request){
        $equipment_name_info = Equipment::where('id', $request->viewEquipmentId)->get();
        return response()->json([
            'equipment_name_info' => $equipment_name_info, 
        ]);
    }

    public function getEquipmentModelInfoById(Request $request){
        $equipment_model_info = EquipmentModel::where('id', $request->equipmentModelId)->get();
        return response()->json([
            'equipment_model_info' => $equipment_model_info, 
        ]);
    }
    
    //============================== CHANGE EQUIPMENT STAT ==============================
    public function changeEquipmentModelStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'equipment_model_id'  => 'required',
            'status'        => 'required',
        ]);

        if($validator->passes()){
            EquipmentModel::where('id', $request->equipment_model_id)
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
