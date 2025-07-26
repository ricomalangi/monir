<?php

namespace App\Commands;

use App\Models\RelayModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TimerModel;

class CheckTimer extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'timer:check';
    protected $description = 'Cek semua timer dan update status jika sudah selesai.';

    public function run(array $params)
    {
        $timerModel = new TimerModel();
        $relay = new RelayModel();
        $now = date('Y-m-d H:i:s');

        $timers = $timerModel
            ->where('status', 'running')
            ->where('end_time <=', $now)
            ->findAll();

        foreach ($timers as $timer) {
            // Update status ke 'finished'
            $timerModel->update($timer['id'], ['status' => 'finished']);
            // Update status relay sesuai relay_id menjadi 0 (OFF)
            if (isset($timer['relay_id'])) {
                $relay->update($timer['relay_id'], ['status' => 0]);
            }
            // Tambahkan aksi lain jika perlu, misalnya kirim email
            CLI::write("Timer ID {$timer['id']} telah selesai dan relay {$timer['relay_id']} dimatikan.", 'green');
        }

        CLI::write("Pemeriksaan selesai.", 'yellow');
    }
}
