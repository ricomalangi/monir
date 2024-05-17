<?php

namespace App\Controllers;
use App\Models\UserModel;

class Recievedata extends BaseController
{
    public function index()
    {
        $kamar = $this->request->getGet('kamar');
        $liter = $this->request->getGet('liter');
        
        $db = \Config\Database::connect();
        $data = [
            'kode_kamar' => $kamar,
            'penggunaan_air' => $liter
        ];
        $db->table('tb_liter_air')->insert($data);
        return $this->response->setJSON([
            'kamar' => $kamar,
            'liter' => $liter
        ]);
    }
   
}