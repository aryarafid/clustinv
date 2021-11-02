<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\data_model;
use App\Models\penjualan_model;
use App\Models\rinc_penjualan_model;
use App\Models\auth_model;

// use App\Controllers\Rekap_data;

class PRouter extends BaseController
{
    protected $auth_model;
    protected $username = 'admin';
    protected $password = 'admin';

    public function __construct()
    {
        $session = session();

        // if ($session->username != true) {
        //     return redirect()->to('Auth');
        // }

        
        $this->data_model = new data_model();
        $this->penjualan_model = new penjualan_model();
        $this->rinc_penjualan_model = new rinc_penjualan_model();
        $this->auth_model = new auth_model();
        $this->Rekap_data = new Rekap_data();

        helper(['form', 'url']);
        // $this->form_validation = \Config\Services::validation();
    }

    public function index()
    {
        $session = session();

        if ($session->masuk == TRUE) {
            // $this->load->view("template_2/dashboard");
            $data = [
                'title'        => 'Home Aplikasi Clustering Inventory Tlogomart',
                'heading'     => 'Selamat Datang di Aplikasi Clustering Inventory Tlogomart.',
            ];
            return view('home2', $data);
        } else {
            return view('loginview');
        }



        // return $this->response->redirect(site_url('Home'), 'refresh');

    }
}
