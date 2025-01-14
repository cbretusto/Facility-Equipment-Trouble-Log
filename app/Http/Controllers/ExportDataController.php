<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ExportData;
use App\Models\FETL;

class ExportDataController extends Controller
{
    public function export($equipment,$equipmentModel,$from,$to){
        date_default_timezone_set('Asia/Manila');

        // if($equipmentModel == 'null'){
        //     $get = 'equipment_id';
        //     $git = $equipment;
        // }else{
        //     $get = 'equipment_model_id';
        //     $git = $equipmentModel;
        // }

        if (preg_match('/\b || \b/', $equipment)) {
            $equipment_checking = str_replace("||","/",$equipment);            
        }else{
            $equipment_checking = $equipment;
        }

        if (preg_match('/\b || \b/', $equipmentModel)) {
            $equipment_model_checking = str_replace("||","/",$equipmentModel);            
        }else{
            $equipment_model_checking = $equipmentModel;
        }

        $trouble_logs_report = FETL::with([
            'trouble_logs_equipment_info',
            'trouble_logs_equipment_model_info',
            'created_by_info',
            'noted_by_info',
            'checked_by_info'
        ]);
        $trouble_logs_report->when($equipment != 'null', function ($q) use($equipment_checking){
            return $q->where('equipment_id', $equipment_checking);
        });
        $trouble_logs_report->when($equipmentModel != 'null', function ($q) use($equipment_model_checking){
            return $q->where('equipment_model_id', $equipment_model_checking);
        });
        $trouble_logs_report->whereDate('created_at','>=',$from);
        $trouble_logs_report->whereDate('created_at','<=',$to);

        $trouble_logs_details = $trouble_logs_report->get();

        // ->where($get, $git)
        // ->where('status', 1)
        // ->where('logdel', 0)
        // ->whereDate('created_at','>=',$from)
        // ->whereDate('created_at','<=',$to)
        // ->get();
        
        if(count($trouble_logs_details) > 0){
            return Excel::download(new ExportData($trouble_logs_details), ''.$trouble_logs_details[0]->trouble_logs_equipment_info->equipment.' - Facility Equipment Trouble Logs Report.xlsx');
        }else{
            return redirect()->back()->with('message', 'There are no data for the chosen date.');
        }
    }

    // public function export($equipment,$equipmentModel,$from,$to){
    //     date_default_timezone_set('Asia/Manila');

    //     if($equipmentModel == 'null'){
    //         $get = 'equipment_id';
    //         $git = $equipment;
    //     }else{
    //         $get = 'equipment_model_id';
    //         $git = $equipmentModel;
    //     }

    //     $trouble_logs_details = FETL::with([
    //         'trouble_logs_equipment_info',
    //         'trouble_logs_equipment_model_info',
    //         'created_by_info',
    //         'noted_by_info',
    //         'checked_by_info'
    //     ])
    //     ->where($get, $git)
    //     ->where('status', 1)
    //     ->where('logdel', 0)
    //     ->whereDate('created_at','>=',$from)
    //     ->whereDate('created_at','<=',$to)
    //     ->get();
        
    //     if(count($trouble_logs_details) > 0){
    //         return Excel::download(new ExportData($trouble_logs_details), ''.$trouble_logs_details[0]->trouble_logs_equipment_info->equipment.' - Facility Equipment Trouble Logs Report.xlsx');
    //     }else{
    //         return redirect()->back()->with('message', 'There are no data for the chosen date.');
    //     }
    // }
}
