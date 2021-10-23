<?php

namespace App\Models;

use CodeIgniter\Model;

class tanggal_model extends Model
{
    protected $table      = 'tanggal';
    protected $primaryKey = 'tanggal_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;


    protected $allowedFields = ['tanggal_id','start_date', 'end_date'];
}
