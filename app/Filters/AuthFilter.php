<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Session\Session;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // session()->destroy;
        // if (session()->masuk == false) {

        // if (session()->has('masuk') == FALSE) {
        //     //     // return redirect()->to('/Auth');

        //     return redirect()->to(site_url('/Auth'));
        // }

        if (!session()->get('masuk')) {
            return redirect()->to(base_url('Auth'));
        }

        // $session = session();
        // $sess = $session->get();
        // var_dump($sess);
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
