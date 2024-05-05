<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tb_user';
    protected $allowedFields = ['id','nama_lengkap', 'email', 'no_hp', 'password'];
    public function getUsers($id = false){
        if($id === false){
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}