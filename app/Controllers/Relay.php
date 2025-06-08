<?php

namespace App\Controllers;

use App\Models\RelayModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Relay extends BaseController
{
    public function index(): string
    {
        helper('form');
        $model = model(RelayModel::class);
        $data['relay'] = $model->getRelay();
        return view('relay/index', $data);
    }
    public function add()
    {
        helper('form');
        $model =  model(UserModel::class);
        $data['users'] = $model->getUsers();
        return view('kamar/create', $data);
    }
    public function store()
    {
        helper(['form', 'text']);
        $data = $this->request->getPost(['nama_kamar', 'id_user']);
        if (!$this->validateData($data, [
            'nama_kamar' => 'required',
            'id_user' => 'required|integer'
        ])) {
            return $this->add();
        }

        $post = $this->validator->getValidated();
        // echo("<pre>");print_r($post);echo("</pre>");
        // die();
        $model = model(KamarModel::class);
        $model->save([
            'nama_kamar' => strtoupper($post['nama_kamar']),
            'id_user' => $post['id_user']
        ]);
        return redirect()->to('/kamar');
    }

    public function edit($id)
    {
        helper('form');
        $kamar = model(KamarModel::class);
        $user = model(UserModel::class);
        $data['kamar'] = $kamar->where('id', $id)->first();
        $data['users'] = $user->getUsers();
        return view('kamar/edit', $data);
    }

    public function update()
    {
        helper(['form', 'text']);
        $data = $this->request->getPost(['id', 'nama_kamar', 'id_user']);
        $id = $data['id'];

        if (!$this->validateData($data, [
            'id' => 'required|integer',
            'nama_kamar' => 'required',
            'id_user' => 'required|integer'
        ])) {
            return $this->edit($id);
        }

        $post = $this->validator->getValidated();
        $model = model(KamarModel::class);
        $data_to_update = [
            'nama_kamar' => $post['nama_kamar'],
            'id_user' => $post['id_user']
        ];
        $model->update($id, $data_to_update);
        return redirect()->to('/kamar');
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || !in_array($status, ['0', '1'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid'
            ])->setStatusCode(400);
        }

        $lampuModel = new RelayModel();
        $update = $lampuModel->update($id, ['status' => $status]);

        return $this->response->setJSON([
            'success' => $update ? true : false,
            'message' => $update ? 'Status berhasil diperbarui' : 'Gagal update database',
            'csrfToken' => csrf_hash() // kirim token baru
        ]);
    }
}
