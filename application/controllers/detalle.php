<?php

class Detalle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->library('carrito');
        $this->load->model('productos');
        $this->load->helper('monedas');
    }

    public function index($id) {
        $this->iniciar();
        $producto = $this->productos->DetallesDe($id);
        if ($producto == null) {
           $cuerpo['d1']=$this->load->view('404', '', true);
           $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if (@!$this->input->post('add')) {
                $this->mostrarDetalle($id, $producto);
            } else {
                if ($this->input->post('cant') < 0 || $this->input->post('cant') > $producto[0]['stock']) {
                    $producto[0]['pasado'] = 1;
                    $this->mostrarDetalle($id, $producto);
                } else {
                    $this->guardar($id, $producto);
                }
            }
        }
    }
    
    public function iniciar(){
        if (!isset($_SESSION['moneda'])) {
            $this->session->set_userdata(array('moneda'=>'EUR', 'tarifa'=>1));
        }   
    }

    public function mostrarDetalle($id, $producto) {
        $categorias = $this->productos->Categorias();
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('product-details', array('pro' => $producto), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function guardar($id, $producto) {
        $carrito = array('id' => $id,
            'nombre' => $producto['0']['nombrePro'],
            'precio' => $producto['0']['precio'],
            'img' => $producto['0']['imagen'],
            'unidades' => $this->input->post('cant'));
        $this->carrito->introduce_pro($carrito);
        redirect('/Cart/muestraCart', 'location', 301);
    }

}
