<?php

namespace App\Controllers;
use App\Models\KamarModel;
use App\Models\UserModel;
class Dashboard extends BaseController
{
    public function index(): string
    {
        $user = model(UserModel::class);
        $kamar = model(KamarModel::class);
        $data = [
            'total_kamar' => $user->countAll(),
            'total_user' => $kamar->countAll()
        ];
        return view('dashboard', $data);
    }
}