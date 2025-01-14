<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipment;
use App\Models\EquipmentModel;

class EquipmentModel extends Model
{
    protected $table = 'equipment_models';
    protected $connection = 'mysql';

}
