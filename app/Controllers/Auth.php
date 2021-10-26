<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\rinc_penjualan_model;
use App\Models\auth_model;


// use App\Controllers\Rekap_data;

class Auth extends BaseController
{
    protected $data_model;

    public function __construct()
    {
        $this->data_model = new data_model();
        $this->penjualan_model = new penjualan_model();
        $this->rinc_penjualan_model = new rinc_penjualan_model();
        helper('url');
        $this->Rekap_data = new Rekap_data();
        $this->auth_model = new auth_model();
		$this->form_validation = \Config\Services::validation();
		$this->session = session();
        // $this->load->library('session');
    }

    public function index()
    {
        $data = [
            'title'      => 'Login Admin ClustInv',
            // 'heading'    => 'Halaman untuk Memproses Data Penjualan',
        ];
        return view('loginview', $data);
    }

    public function logger()
	{
		if ($this->request->getPost()) {
			//lakukan validasi untuk data yang di post
			// $data = $this->request->getPost();
			// $validate = $this->validation->run($data, 'logcheck');
			$errors = $this->validation->getErrors();

			if ($errors) {
				return view('login_view');
			}

			$auth_model = new \App\Models\auth_model();

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');

			$user = $auth_model->where('username', $username)->first();

			if ($user) {
				if ($user['password'] != $password) {
					$this->session->setFlashdata('msg', 'Password Salah');
				} else {
					$sessData = [
						'user_id' => $user['user_id'],
						'username' => $user['username'],
						'masuk' => TRUE
					];

					// var_dump($sessData);

					$this->session->set($sessData);
					echo "<script>alert('Berhsail masuk!');window.location = '" . base_url() . "';</script>";

					return redirect()->to(base_url());
				}
			} else {
				$this->session->setFlashdata('msg', 'User Tidak Ditemukan');
			}
		}
		return view('login_view');
	}

    public function logout()
	{
		if ($this->session->has('masuk') == TRUE) {
			# code...

			$this->session->destroy();

			$arr = [
				'username'  => 'Guest',
				// 'user_id' => '0',
				// 'masuk' => FALSE
			];

			$this->session->set($arr);
			echo "<script>alert('Berhsail keluar!');window.location = '" . base_url() . "';</script>";

			return redirect()->to(base_url());
		} else {
			// return redirect('base_url()');
			return redirect()->to(base_url());
		}
	}
}
