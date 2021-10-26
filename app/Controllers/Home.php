<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'title'		=> 'Home Aplikasi Clustering Inventory Tlogomart',
			'heading' 	=> 'Selamat Datang di Aplikasi Clustering Inventory Tlogomart.',
		];
		return view('home2', $data);
	}

}
