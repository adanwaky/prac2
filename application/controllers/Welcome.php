<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->helper('monedas');
        
    }
    public function index() {       
        
        if (!isset($_SESSION['moneda'])) {
            $this->cambiarTarifa('EUR');
        }               
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
        $fecha=date('Y-m-d');
         $XML = simplexml_load_file('./assets/xml_monedas/'.$fecha.'-moneda.xml');
                
        foreach ($XML->Cube->Cube->Cube as $rate) {
            if ($rate["currency"] == $moneda) {
                return $rate['rate'];
            }
        }
    } 
    
    function cambiarTarifa($moneda) {
        $tarifa = $this->devuelveTarifa($moneda);
        $this->session->set_userdata(array('moneda' => (string) $moneda, 'tarifa' => (string) $tarifa));
        $this->index();
    }

}
