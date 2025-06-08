<?php

namespace App\Controllers;

class Recievedata extends BaseController
{
    public function index()
    {
        $voltage = $this->request->getGet('voltage') ?? 0;
        $current = $this->request->getGet('current') ?? 0;
        $power = $this->request->getGet('power') ?? 0;
        $energy = $this->request->getGet('energy') ?? 0;
        $frequency = $this->request->getGet('frequency') ?? 0;
        $pf = $this->request->getGet('pf') ?? 0;

        $db = \Config\Database::connect();
        $data = [
            'voltage' => $voltage,
            'current' => $current,
            'power' => $power,
            'energy' => $energy,
            'frequency' => $frequency,
            'pf' => $pf
        ];
        $db->table('tb_data')->insert([
            'data' => json_encode($data),
            'created_at' => date("Y-m-d h:i:sa")
        ]);
        return $this->response->setJSON([
            'data' => $data,
            'created_at' => date("Y-m-d h:i:s")
        ]);
    }
}
