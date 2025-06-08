<?php

namespace App\Models;

use CodeIgniter\Model;

class RelayModel extends Model
{
    protected $table = 'tb_relay';
    protected $allowedFields = ['nama_relay', 'status'];
    public function getRelay($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
