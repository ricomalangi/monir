<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class VoiceCommand extends ResourceController
{
    // Tangani POST request dari frontend dengan teks suara
    public function process()
    {
        $input = $this->request->getJSON();

        if (!$input || !isset($input->command)) {
            return $this->fail("Perintah tidak ditemukan", 400);
        }

        $command = strtolower(trim($input->command));
        $response = '';

        // Logika sederhana untuk command suara
        if (strpos($command, 'hidupkan lampu') !== false) {
            $response = 'Lampu dihidupkan.';
            // TODO: Di sini bisa kamu hubungkan ke sistem IoT atau hardware
        } elseif (strpos($command, 'matikan lampu') !== false) {
            $response = 'Lampu dimatikan.';
            // TODO: Hubungkan ke perangkat
        } else {
            $response = 'Perintah tidak dikenali.';
        }

        return $this->respond(['message' => $response]);
    }
}
