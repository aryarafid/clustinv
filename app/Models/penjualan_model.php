<?php

namespace App\Models;

use CodeIgniter\Model;

class penjualan_model extends Model
{
    protected $table      = 'penjualan';
    protected $primaryKey = 'penjualan_id';

    protected $useAutoIncrement = true;
    

    protected $returnType     = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['penjualan_id','tanggal_id', 'kode', 'nama_produk', 'terjual', 'frek'];
}