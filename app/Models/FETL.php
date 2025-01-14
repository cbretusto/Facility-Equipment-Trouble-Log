<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipment;
use App\Models\RapidXUser;
use App\Models\EquipmentModel;

class FETL extends Model
{
    protected $table = "fetls";
    protected $connection = "mysql";

    public function equipment_details(){
        return $this->hasMany(Equipment::class, 'equipment_id', 'id');
    }

    public function trouble_logs_equipment_info(){
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }

    public function trouble_logs_equipment_model_info(){
        return $this->hasOne(EquipmentModel::class, 'id', 'equipment_model_id');
    }

    public function created_by_info(){
        return $this->hasOne(RapidXUser::class, 'id', 'created_by');
    }

    public function noted_by_info(){
        return $this->hasOne(RapidXUser::class, 'id', 'noted_by');
    }

    public function checked_by_info(){
        return $this->hasOne(RapidXUser::class, 'id', 'checked_by');
    }
}
