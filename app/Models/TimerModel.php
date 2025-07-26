<?php

namespace App\Models;

use CodeIgniter\Model;

class TimerModel extends Model
{
    protected $table      = 'tb_timer';
    protected $primaryKey = 'id';

    protected $allowedFields = ['start_time', 'end_time', 'status', 'relay_id'];
}
