<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->library('carrito');
        $this->load->model('productos');
    }

    public function muestraCart($mensaje = null) {
        if (!$this->input->post('upd') && !$this->input->post('comprar')) {
            $euros = $this->carrito->precio_total();
            $carro = $this->carrito->get_content();
            $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro, 'euros' => $euros, 'mensaje' => $mensaje), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('upd')) {
                $this->actualizar($this->input->post());
            }
            if ($this->input->post('comprar')) {
                if (!$this->session->userdata('login')) {
                   $this->session->set_userdata(array('comprando'=>'comprando'));
                    redirect('/Login/index', 'location', 301);
                } else {
                    $this->realizarcompra($this->session->userdata('user'));
                }
            }
        }
    }

    public function guardar($id, $unidades = 1) { //GUARDA DESDE INICIO
        $producto = $this->productos->DetallesDe($id);
        $prod = array('id' => $producto[0]['idPro'],
            'nombre' => $producto[0]['nombrePro'],
            'precio' => $producto[0]['precio'],
            'img' => $producto[0]['imagen'],
            'unidades' => $unidades);
        $this->carrito->introduce_pro($prod, $producto[0]['stock']);
        redirect('/Cart/muestraCart', 'location', 301);
    }

    public function guardarPro($id, $unidades) { //GUARDA EN VISTA DETALLE
        $producto = $this->productos->DetallesDe($id);
        $prod = array('id' => $producto[0]['idPro'],
            'nombre' => $producto[0]['nombrePro'],
            'precio' => $producto[0]['precio'],
            'img' => $producto[0]['imagen'],
            'unidades' => $unidades);
        $this->carrito->introduce_pro($prod, $producto[0]['stock']);
    }

    public function borrar($id) {
        $unique_id = md5($id);
        $this->carrito->remove_producto($unique_id);
        redirect('/Cart/muestraCart', 'location', 301);
    }

    public function actualizar($POST) {
        foreach ($POST as $key => $value) {
            if ($value == "" || $value == "Actualizar") {
                
            } else {
                $producto = $this->productos->DetallesDe($key);
                if ($value > $producto[0]['stock']) {
                    $mensaje = 'No hay suficiente stock';
                    redirect("/Cart/muestraCart/$mensaje", 'location', 301);
                } else {
                    $this->guardarPro($key, $value);
                }
            }
        }
        redirect('/Cart/muestraCart', 'location', 301);
    }

    public function realizarcompra() {
        $datosUser = $this->usuarios->DevuelveDatosUs($this->session->userdata('user'));
        $provincia = $this->provincias->DevuelveProvincia($datosUser[0]['provincias_id']);
        $euros = $this->carrito->precio_total();
        $carro = $this->carrito->get_content();
        $cuerpo['d1'] = $this->load->view('checkout', array('carro' => $carro, 'euros' => $euros,
            'datos' => $datosUser, 'provincia' => $provincia), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

}
