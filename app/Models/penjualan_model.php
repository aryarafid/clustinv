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

    protected $allowedFields = ['start_date', 'end_date', 'timestamp_enterdata', 'dbi', 'selisih_simpangan'];

    public function getDateTStamp($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $query = $builder->getWhere(['penjualan_id' => $id]);
        return $query->getResultArray();
    }
}
