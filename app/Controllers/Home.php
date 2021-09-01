<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data=[
			'title'		=> 'Dashboard ClustInv',
			'heading' 	=> 'Dashboard Aplikasi Clustering Inventory Tlogomart',
		];
		return view('home2', $data);
	}
}
