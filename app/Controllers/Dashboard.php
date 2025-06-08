<?php

namespace App\Controllers;

use App\Models\KamarModel;
use App\Models\RelayModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        // $user = model(UserModel::class);
        $relay = model(RelayModel::class);
        $data = [
            'lampu' => $relay->getRelay(1)
        ];
        return view('dashboard', $data);
    }
}
