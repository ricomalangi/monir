<?php

namespace App\Controllers;

use App\Models\DataSensorModel;
use App\Models\KamarModel;
use App\Models\RelayModel;
use App\Models\TimerModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $harga = 0;
        $jsonPath = WRITEPATH . 'harga_listrik.json';
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            $harga = $jsonData['harga'] ?? 0;
        }
        $relay = model(RelayModel::class);
        $timer = model(TimerModel::class);
        $timer = $timer->where('relay_id', 1)->first();
        $lama_timer = 0;
        if ($timer) {
            $start = strtotime($timer['start_time']);
            $end = strtotime($timer['end_time']);
            $lama_timer = ($end - $start) / 60;
        }
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

        // Ambil data terakhir dari model DataSensorModel
        $get_last_power = $data_sensor->where("MONTH(created_at) = $month")
            ->where("YEAR(created_at) = $tahun")
            ->orderBy('created_at', 'DESC')
            ->first();
        $get_last_power = json_decode($get_last_power['data'], true);
        $get_last_power = $get_last_power['energy'];

        // Hitung total jam berdasarkan selisih waktu created_at
        $totalJam = 0;
        if (count($results) > 1) {
            $start = strtotime($results[0]['created_at']);
            $end = strtotime($results[count($results) - 1]['created_at']);
            $totalJam = number_format(($end - $start) / 3600, 3);
        }
        $total_bayar = $get_last_power * $harga;
        $data = [
            'lampu' => $relay->getRelay(1),
            'month' => $month,
            'bulan_berjalan' => $bulan_berjalan,
            'total_power' => $get_last_power,
            'total_bayar' => $total_bayar,
            'total_jam' => $totalJam,
            'harga_listrik' => $harga,
            'timer_lampu' => $lama_timer
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

        $data_sensor = model(DataSensorModel::class);

        $query = $data_sensor
            ->select('data')
            ->where('MONTH(created_at)', $bulan)
            ->where('YEAR(created_at)', $tahun)
            ->get();

        $get_last_power = $data_sensor->where("MONTH(created_at) = $bulan")
            ->where("YEAR(created_at) = $tahun")
            ->orderBy('created_at', 'DESC')
            ->first();

        $get_last_power = isset($get_last_power) ? json_decode($get_last_power['data'], true) : 0;
        $get_last_power = $get_last_power['energy'] ?? 0;
        // Hitung total jam berdasarkan selisih waktu created_at
        $resultRows = $data_sensor
            ->select('created_at')
            ->where('MONTH(created_at)', $bulan)
            ->where('YEAR(created_at)', $tahun)
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $totalJam = 0;
        if (count($resultRows) > 1) {
            $start = strtotime($resultRows[0]['created_at']);
            $end = strtotime($resultRows[count($resultRows) - 1]['created_at']);
            $totalJam = number_format(($end - $start) / 3600, 3);
        }

        $harga = 0;
        $jsonPath = WRITEPATH . 'harga_listrik.json';
        if (file_exists($jsonPath)) {
            $jsonData = json_decode(file_get_contents($jsonPath), true);
            $harga = $jsonData['harga'] ?? 0;
        }
        $total_harga = $get_last_power * $harga;
        return $this->response->setJSON([
            'success' => true,
            'total_power' => number_format($get_last_power, 2),
            'total_jam' => $totalJam,
            'total_harga' => $total_harga,
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

    public function chartPower()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = date('Y');
        $dataModel = model(DataSensorModel::class);
        $results = $dataModel
            ->where("MONTH(created_at)", $bulan)
            ->where("YEAR(created_at)", $tahun)
            ->findAll();
        $dailyLastEnergy = [];
        foreach ($results as $row) {
            $tanggal = date('Y-m-d', strtotime($row['created_at']));
            // Simpan data terakhir (created_at terbesar) untuk setiap tanggal
            if (!isset($dailyLastEnergy[$tanggal]) || strtotime($row['created_at']) > strtotime($dailyLastEnergy[$tanggal]['created_at'])) {
                $json = json_decode($row['data'], true);
                $energy = isset($json['energy']) ? (float)$json['energy'] : 0;
                $dailyLastEnergy[$tanggal] = [
                    'created_at' => $row['created_at'],
                    'energy' => $energy
                ];
            }
        }

        ksort($dailyLastEnergy);
        $labels = [];
        $data = [];
        foreach ($dailyLastEnergy as $tanggal => $info) {
            $labels[] = date('d M', strtotime($tanggal));
            $data[] = $info['energy'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'data' => $data,
            'csrfToken' => csrf_hash()
        ]);
    }

    public function updateRelay()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status'); // 1 = ON, 0 = OFF

        $lampuModel = new RelayModel();
        $updated = $lampuModel->update($id, ['status' => $status]);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status AC berhasil diubah',
                'csrfToken' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status AC',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(500);
        }
    }

    public function setTimer()
    {
        $timer = $this->request->getPost('timer');
        $relay_id = $this->request->getPost('relay_id');
        if (!$timer || !$relay_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Timer dan Relay Id tidak boleh kosong',
                'csrfToken' => csrf_hash()
            ])->setStatusCode(400);
        }

        $timerModel = model(\App\Models\TimerModel::class);
        $start_time = date('Y-m-d H:i:s');
        $end_time = date('Y-m-d H:i:s', strtotime("+$timer minutes"));
        $data = [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'running'
        ];

        $existing = $timerModel->where('relay_id', $relay_id)->first();
        if ($existing) {
            $timerModel->update($existing['id'], $data);
            $msg = 'Timer berhasil diupdate';
        } else {
            $data['relay_id'] = $relay_id;
            $timerModel->insert($data);
            $msg = 'Timer berhasil disimpan';
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $msg,
            'csrfToken' => csrf_hash()
        ]);
    }
}
