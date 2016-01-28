<?php

class Detalle extends CI_Controller {

    public function index($id) {

        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->library('carrito');

        $producto = $this->Productos->DetallesDe($id);
        if (@!$_POST['add']) {
            $this->mostrarDetalle($id, $producto);
        } else {
            if ($this->input->post('cant') < 0 || $this->input->post('cant') > $producto[0]['stock']) {
                $productos[0]['pasado'] = 1;
                $this->mostrarDetalle($id, $producto);
            } else {
                $this->guardar($id, $producto);
                //  $this->session->unset_userdata('carrito');
            }
        }
    }

    public function mostrarDetalle($id, $producto) {

        $categorias = $this->Productos->Categorias();
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
