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
    /**
     * INICIO DE LA APLICACIÓN
     */
    public function index() {
        if (!$this->session->userdata('moneda')) { //SI NO EXISTE LA SESIÓN MONEDA LA CREA
            $this->session->set_userdata(array('moneda'=>'EUR', 'tarifa'=>1));
        }  
        $categorias = $this->Productos->Categorias(); //GUARDA LAS CATEGORIAS
        $productos = $this->Productos->ProductosDestacados(); //GUARDA LOS PRODUCTOS DESTACADOS
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('index', array('pro' => $productos), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        //CARGA LA VISTA
    }
/**
 * DEVUELVE LA TARIFA DE UNA MONEDA BUSCANDO EN EL FICHERO XML
 * @param type $moneda
 * @return int
 */
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
    
    /**
     * CAMBIA LA MONEDA Y LA TARIFA EN LA SESIÓN Y CARGA A LA PÁGINA QUE ESTABA
     * @param type $moneda
     */
    function cambiarTarifa($moneda) {
        $tarifa = $this->devuelveTarifa($moneda);
        $this->session->set_userdata(array('moneda' => (string) $moneda, 'tarifa' => (string) $tarifa));
       header("Location:".$_SESSION['pag_act']);
       
    }

}
