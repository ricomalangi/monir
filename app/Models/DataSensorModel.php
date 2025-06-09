<?php

namespace App\Models;

use CodeIgniter\Model;

class DataSensorModel extends Model
{
    protected $table = 'tb_data';
    protected $allowedFields = ['data', 'created_at'];
}
