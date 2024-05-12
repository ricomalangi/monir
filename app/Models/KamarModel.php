<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table = 'tb_kamar';
    protected $allowedFields = ['nama_kamar','id_user','penggunaan_air'];
    public function getKamar($id = false){
        if($id === false){
            return $this->select('tb_kamar.*, tb_user.nama_lengkap')->join('tb_user', 'tb_user.id = tb_kamar.id_user', 'left')->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

}