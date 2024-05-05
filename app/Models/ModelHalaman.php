<?php
namespace App\Models;

use CodeIgniter\Model;

class ModelHalaman extends Model
{
    protected $table  = 'halaman';
    protected $primaryKey = 'halaman_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['halaman_judul', 'halaman_isi'];

    // protected bool $allowEmptyInserts = false;
}
