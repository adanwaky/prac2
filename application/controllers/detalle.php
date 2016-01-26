<?php

class Detalle extends CI_Controller {

    public function index($producto) {

        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->library('carrito');

        $productos = $this->Productos->DetallesDe($producto);
        if (@!$_POST['add']) {
            $this->mostrarDetalle($producto, $productos);
        } else {
            if ($this->input->post('cant') < 0 || $this->input->post('cant') > $productos[0]['stock']) {
                $productos[0]['pasado'] = 1;
                $this->mostrarDetalle($producto, $productos);
            } else {

                $this->guardar();
                $this->mostrarCarrito();
                //  $this->session->unset_userdata('carrito');
            }
        }
    }

    public function mostrarDetalle($producto, $productos) {

        $categorias = $this->Productos->Categorias();
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('product-details', array('pro' => $productos), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function mostrarCarrito() {

        $carro = $_SESSION['carrito'];
        $cuerpo = [];
        $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function guardar() {
        $carrito = array('id' => $this->input->post('id'),
            'nombre' => $this->input->post('nombre'),
            'precio' => $this->input->post('precio'),
            'img' => $this->input->post('img'),
            'unidades' => $this->input->post('cant'));
        $this->carrito->introduce_pro($carrito);
    }

}
