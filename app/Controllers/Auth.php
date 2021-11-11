<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\rinc_penjualan_model;
use App\Models\auth_model;

// use App\Controllers\Rekap_data;

class Auth extends PRouter
{
	protected $auth_model;
	protected $username = 'admin';
	protected $password = 'admin';

	public function __construct()
	{
		helper(['form', 'url']);
		$this->form_validation = \Config\Services::validation();
		$this->session = session();
	}

	public function index()
	{
		// $sessData = [
		// 	'masuk' => FALSE,
		// ];
		// $this->session->set($sessData);

		// $data = [
		// 	'title'      => 'Login Admin ClustInv',
		// 	// 'heading'    => 'Halaman untuk Memproses Data Penjualan',
		// ];

		if ($this->session->masuk == TRUE) {
			return redirect()->to(base_url());
		}
		return view('loginview');
	}

	public function logger()
	{
		$iusername = $this->request->getPost('username');
		$ipassword = $this->request->getPost('password');

		if (($iusername != $this->username) && ($ipassword != $this->password)) {
			$this->session->setFlashdata('msg', 'Username & Password Salah');
			return redirect()->to(base_url() . "/Auth");
		} elseif ($iusername != $this->username) {
			$this->session->setFlashdata('msg', 'Username Salah');
			return redirect()->to(base_url() . "/Auth");
		} elseif ($ipassword != $this->password) {
			$this->session->setFlashdata('msg', 'Password Salah');
			return redirect()->to(base_url() . "/Auth");
		} else {
			$userData = [
				'masuk' => TRUE
			];
			$this->session->set($userData);
			return redirect()->to(base_url());
		};
	}

	public function logout()
	{
		if ($this->session->has('masuk') == TRUE) {
			$this->session->destroy();

			$userData = [
				'masuk' => FALSE
			];

			$this->session->set($userData);
			echo "<script>alert('Berhasil keluar!');</script>";

			// return redirect()->to(base_url());
			return view('loginview');
		} else {
			// return redirect('base_url()');
			return redirect()->to(base_url());
		}
	}
}
