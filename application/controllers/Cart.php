<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function muestraCart($mensaje = null) {
        if (!$this->input->post('upd') && !$this->input->post('comprar')) {
            $this->load->library('carrito');
            $this->load->helper('url');
            $this->load->library('session');

            $euros = $this->carrito->precio_total();
            $carro = $this->carrito->get_content();
            $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro, 'euros' => $euros, 'mensaje' => $mensaje), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $this->load->helper('url');
            $this->load->library('session');
            if ($this->input->post('upd')) {
                $this->actualizar($_POST);
            }
            if ($this->input->post('comprar')) {
                if (!$this->session->userdata('login')) {
                    $_SESSION['comprando'] = 'comprando';
                    redirect('/Login/index', 'location', 301);
                } else {
                    $this->realizarcompra($this->session->userdata('user'));
                }
            }
        }
    }

    public function guardar($id, $unidades = 1) { //GUARDA DESDE INICIO
        $this->load->model('productos');
        $this->load->library('carrito');
        $this->load->helper('url');
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
        $this->load->model('productos');
        $this->load->library('carrito');
        $this->load->helper('url');
        $producto = $this->productos->DetallesDe($id);
        $prod = array('id' => $producto[0]['idPro'],
            'nombre' => $producto[0]['nombrePro'],
            'precio' => $producto[0]['precio'],
            'img' => $producto[0]['imagen'],
            'unidades' => $unidades);
        $this->carrito->introduce_pro($prod, $producto[0]['stock']);
    }

    public function borrar($id) {
        $this->load->library('carrito');
        $this->load->helper('url');
        $unique_id = md5($id);
        $this->carrito->remove_producto($unique_id);
        redirect('/Cart/muestraCart', 'location', 301);
    }

    public function actualizar($POST) {
        foreach ($POST as $key => $value) {
            if ($value == "" || $value == "Actualizar") {
                
            } else {
                $this->load->model('productos');
                $this->load->helper('url');
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
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->library('carrito');
        

        $datosUser = $this->usuarios->DevuelveDatosUs($_SESSION['user']);
        $provincia = $this->provincias->DevuelveProvincia($datosUser[0]['provincias_id']);
        $euros = $this->carrito->precio_total();
        $carro = $this->carrito->get_content();
        
        $cuerpo['d1'] = $this->load->view('checkout', array('carro' => $carro, 'euros' => $euros,
            'datos' => $datosUser, 'provincia' => $provincia), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

}
