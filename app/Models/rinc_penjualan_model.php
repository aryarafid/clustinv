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

    public function selectbyid($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('rinc_penjualan');
        $query = $builder->getWhere(['penjualan_id' => $id]);
        return $query->getResultArray();
    }

    public function selectbyidcl($id, $cluster)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('rinc_penjualan');
        $query = $builder->getWhere(['penjualan_id' => $id, 'cluster' => $cluster]);
        return $query->getResultArray();
    }

    public function changeAlias($id, $alias)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        // $query = $builder->getWhere(['penjualan_id' => $id, 'cluster' => $cluster]);
        $data = [
            'nama_alias' => $alias,
        ];
        $builder->where('penjualan_id', $id);
        $query = $builder->update($data);
        return $query;
    }

    public function cust_delete($id)            //custom delete
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('rinc_penjualan');
        $builder = $db->table('penjualan');
        $query = $builder->delete(['penjualan_id' => $id]);
        return $query;
    }
}
