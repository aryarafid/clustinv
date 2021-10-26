<?php namespace App\Models;

use CodeIgniter\Model;

class auth_model extends Model
{
    // setting utk level user
    protected $table      = 'user_level';
    protected $primaryKey = 'user_id';
    protected $returnType = 'array';

    public function q_login($username, $password)
	{
		// $query = $this->db->get_where('data_pegawai',array('email_pegawai'=>$email , 'password_pegawai'=> $password), 1);
        $db = \Config\Database::connect();
        $sql= $db->table('user_level');
		$sql= $sql->where('username', $username);
		$sql= $sql->where('password', $password);
        $sql= $sql->get()->getRowArray();
        //retrieve in array biar bisa dimasukin indeks userdata
		return $sql;
    }
    

}