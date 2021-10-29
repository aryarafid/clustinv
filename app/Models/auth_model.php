<?php namespace App\Models;

use CodeIgniter\Model;

class auth_model extends Model
{
    // store user dan pw
    protected $username     = 'admin';
    protected $password     = 'admin';

    public function q_login($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
        return TRUE;
    }
    

}