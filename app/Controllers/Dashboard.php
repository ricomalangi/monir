<?php

namespace App\Controllers;

use App\Models\DataSensorModel;
use App\Models\KamarModel;
use App\Models\RelayModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        // $user = model(UserModel::class);
        $harga = 0;
        $jsonPath = WRITEPATH . 'harga_listrik.json';
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            $harga = $jsonData['harga'] ?? 0;
        }
        $relay = model(RelayModel::class);
        $month = date('m');
        $tahun = date('Y');
        $bulan = [
            "01" => "Januari",
            "02" => "Februari",
            "03" => "Maret",
            "04" => "April",
            "05" => "Mei",
            "06" => "Juni",
            "07" => "Juli",
            "08" => "Agustus",
            "09" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        ];
        foreach ($bulan as $value => $nama) {
            if ($month === $value) {
                $bulan_berjalan = $nama;
            }
        }

        $data_sensor = model(DataSensorModel::class);

        $results = $data_sensor
            ->where("MONTH(created_at) = $month")
            ->where("YEAR(created_at) = $tahun")
            ->findAll();

        $totalPower = 0;

        foreach ($results as $row) {
            $decoded = json_decode($row['data'], true); // gunakan array index
            if (isset($decoded['power'])) {
                $totalPower += (float) $decoded['power'];
            }
        }

        $data = [
            'lampu' => $relay->getRelay(1),
            'month' => $month,
            'bulan_berjalan' => $bulan_berjalan,
            'total_power' => $totalPower,
            'harga_listrik' => $harga
        ];
        return view('dashboard', $data);
    }

    public function getTotalPower()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = date('Y');

        if (!$bulan || !preg_match('/^\d{2}$/', $bulan)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Bulan tidak valid'
            ])->setStatusCode(400);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tb_data');

        $query = $builder
            ->select('data')
            ->where('MONTH(created_at)', $bulan)
            ->where('YEAR(created_at)', $tahun)
            ->get();

        $totalPower = 0;

        foreach ($query->getResult() as $row) {
            $decoded = json_decode($row->data, true);
            if (isset($decoded['power'])) {
                $totalPower += (float) $decoded['power'];
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'total_power' => $totalPower,
            'csrfToken' => csrf_hash()
        ]);
    }

    public function updateHarga()
    {
        $harga = $this->request->getPost('harga');


        $data = ['harga' => (int)$harga];
        $jsonPath = WRITEPATH . 'harga_listrik.json';

        if (file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT))) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Harga listrik berhasil diperbarui',
                'csrfToken' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan data',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(500);
        }
    }
}
