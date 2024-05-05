<?php

namespace App\Controllers;
use App\Models\UserModel;
class User extends BaseController
{
    public function index(): string
    {
        $model = model(UserModel::class);
        $data['users'] = $model->getUsers();
        return view('user/index', $data);
    }
    public function add()
    {
        helper('form');
        return view('user/create');
    }
    public function store()
    {
        helper(['form', 'text']);
        $data = $this->request->getPost(['nama_lengkap', 'email', 'no_hp', 'password']);
        if(!$this->validateData($data, [
            'nama_lengkap' => 'required',
            'email' => 'required|valid_email',
            'no_hp' => 'required|numeric',
            'password' => 'required|min_length[7]'
        ])){
            return $this->add();
        }

        $post = $this->validator->getValidated();
        $model = model(UserModel::class);
        $model->save([
            'nama_lengkap' => $post['nama_lengkap'],
            'email' => $post['email'],
            'no_hp' => $post['no_hp'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/user');
    }
}