<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapidXUser extends Model
{
    protected $table = "users";
    protected $connection = "mysql_rapidx";
}
