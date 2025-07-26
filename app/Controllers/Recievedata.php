<?php

namespace App\Controllers;

use App\Models\DataSensorModel;
use App\Models\RelayModel;

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
            'created_at' => date("Y-m-d H:i:s")
        ]);
        return $this->response->setJSON([
            'data' => $data,
            'created_at' => date("Y-m-d h:i:s")
        ]);
    }

    public function relay($id)
    {
        $relay = model(RelayModel::class);
        $data = $relay->getRelay($id);
        if (!$data) {
            return $this->response->setJSON([
                'message' => 'relay is not found',
            ], 404);
        }
        return $this->response->setBody((string)$data['status'])->setStatusCode(200);
    }

    public function totalHarga()
    {
        $month = date('m');
        $tahun = date('Y');
        $jsonPath = WRITEPATH . 'harga_listrik.json';
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            $harga_listrik = $jsonData['harga'] ?? 0;
        }
        $data_sensor = model(DataSensorModel::class);
        $get_last_power = $data_sensor->where("MONTH(created_at) = $month")
            ->where("YEAR(created_at) = $tahun")
            ->orderBy('created_at', 'DESC')
            ->first();
        $get_last_power = json_decode($get_last_power['data'], true);
        $get_last_power = $get_last_power['energy'];
        $total_harga = $get_last_power * $harga_listrik;

        return $this->response->setBody((string)$total_harga)->setStatusCode(200);
    }
}
