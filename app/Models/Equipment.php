<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\EquipmentModel;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $connection = 'mysql';

    public function equipment_model_info(){
        return $this->hasOne(EquipmentModel::class, 'equipment_id', 'id');
    }

}
