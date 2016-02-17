<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->library('pagination');
        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->library('session');
        echo 'primero';
         echo $_SESSION['moneda'];
        echo $_SESSION['tarifa'] ;
        if (!isset($_SESSION['moneda'])) {
            echo 'entra';
            $this->cambiarTarifa('EUR');
        }
        echo 'despues de if';
         echo $_SESSION['moneda'];
        echo $_SESSION['tarifa'] ;
        $categorias = $this->Productos->Categorias();
        $productos = $this->Productos->ProductosDestacados();
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('index', array('pro' => $productos), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    function devuelveTarifa($moneda) {
        if ($moneda == 'EUR') {
            return 1;
        }
        $XML = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
        foreach ($XML->Cube->Cube->Cube as $rate) {
            if ($rate["currency"] == $moneda) {
                return $rate['rate'];
            }
        }
    }

    function cambiarTarifa($moneda) {
        //$this->load->library('session');
        $tarifa = $this->devuelveTarifa($moneda);
        $_SESSION['moneda'] = $moneda;
        $_SESSION['tarifa'] = $tarifa;
        echo $_SESSION['moneda'];
        echo $_SESSION['tarifa'] ;
       // $this->index();
        //$this->session->set_userdata(array('moneda' => $moneda, 'tarifa' => $tarifa));
    }

}
