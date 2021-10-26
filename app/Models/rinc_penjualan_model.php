<?php

namespace App\Models;

use CodeIgniter\Model;

class rinc_penjualan_model extends Model
{
    protected $table      = 'rinc_penjualan';
    protected $primaryKey = 'id_rincian';

    protected $useAutoIncrement = true;
    

    protected $returnType     = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = ['penjualan_id', 'kode', 'nama_produk', 'terjual', 'frek', 'cluster'];

    
}