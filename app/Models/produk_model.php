<?php

namespace App\Models;

use CodeIgniter\Model;

class produk_model extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'kode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';

    protected $allowedFields = ['kode', 'nama_produk', 'kms', 'hrg_jual', 'netto', 'barcode'];
}