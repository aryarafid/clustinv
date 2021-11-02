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
		// if ($this->request->getPost()) {
		$iusername = $this->request->getPost('username');
		$ipassword = $this->request->getPost('password');

		////		lakukan validasi untuk data yang di post
		// $data = $this->request->getPost();
		// $validate = $this->validation->run($data, 'logcheck');
		// $errors = $this->validation->listErrors();

		// if ($errors) {
		// 	return view('loginview');
		// }


		// $user = $this->auth_model->q_login($username, $password);

		// if ($user) {			//SALAH. USER ITU HARUSNYA RETRIEVE AKUN. INI BUAT UHHHH GIMANA YY       
		if ($ipassword != $this->password) {
			$this->session->setFlashdata('msg', 'Password Salah');
		} else {
			$userData = [
				// 'username' => $iusername,
				'masuk' => TRUE
			];

			// var_dump($sessData);

			$this->session->set($userData);
			echo "<script>alert('Berhasil masuk!');window.location = '" . base_url() . "';</script>";

			// return redirect()->to(base_url());
		};
		// } else {
		// 	$this->session->setFlashdata('msg', 'User Tidak Ditemukan');
		// }
		// }
		// return view('login_view');
	}

	public function logout()
	{
		if ($this->session->has('masuk') == TRUE) {
			# code...

			$this->session->destroy();

			$userData = [
				// 'username'  => 'Guest',
				// 'user_id' => '0',
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
