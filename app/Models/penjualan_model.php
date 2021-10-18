<?php

namespace App\Models;

use CodeIgniter\Model;

class penjualan_model extends Model
{
    protected $table      = 'tanggal';
    protected $primaryKey = 'tanggal_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['tanggal_id', 'kode', 'terjual', 'frek'];
}