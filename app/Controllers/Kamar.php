<?php

namespace App\Controllers;
use App\Models\KamarModel;
use App\Models\UserModel;
class Kamar extends BaseController
{
    public function index(): string
    {
        helper('form');
        $model = model(KamarModel::class);
        $data['kamar'] = $model->getKamar();
        $db = \Config\Database::connect();
        $builder = $db->table('tb_pengaturan');
        $data['harga_air'] =  $builder->select('harga_air, id')->where('id', 1)->get()->getRowArray();
        // echo("<pre>");print_r($data);echo("</pre>");
        // die();
        return view('kamar/index', $data);
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
        if(!$this->validateData($data, [
            'nama_kamar' => 'required',
            'id_user' => 'required|integer'
        ])){
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
        $data = $this->request->getPost(['id','nama_kamar', 'id_user']);
        $id = $data['id'];

        if(!$this->validateData($data, [
            'id' => 'required|integer',
            'nama_kamar' => 'required',
            'id_user' => 'required|integer'
            ])){
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

    public function hargaAir()
    {
        helper(['form', 'text']);
        $data = $this->request->getPost(['id','harga_air']);
        if(!$this->validateData($data, [
            'id' => 'required',
            'harga_air' => 'required',
            ])){
                return $this->index();
        }

        $post = $this->validator->getValidated();
        $db = \Config\Database::connect();
        $builder = $db->table('tb_pengaturan');
        $builder->set('harga_air', $post['harga_air']);
        $builder->where('id', $post['id']);
        $builder->update();
        return redirect()->to('/kamar');
    }

    public function jsonHargaAir()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_pengaturan');
        $hargaAir = $builder->select('harga_air')->where('id', 1)->get()->getRowArray();
    
        if ($hargaAir) {
            return $this->response->setJSON($hargaAir);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data not found']);
        }

    }
}