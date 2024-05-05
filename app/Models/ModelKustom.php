<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class ModelKustom{
    private $db;
    public function __construct() {
        $this->db = \Config\Database::connect();
    }
    public function getData(){
        // $builder = $this->db->table('authors');
        // $builder->select('id,first_name,last_name,email');
        // $data = $builder->getWhere(['id' => 10])->getResult();
        //$sql = $builder->getCompiledSelect(); // mengetahui perintah sql yang sedang dijalankan
        
        $builder = $this->db->table('posts');
        $builder->select('*');
        $builder->where('id', 1);
        $builder->where('author_id', 3);
        // $builder->join('authors', 'authors.id = posts.author_id');
        $sql = $builder->getCompiledSelect();
        $data = $builder->get()->getResult();
        return $data;
    }
}