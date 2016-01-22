<?php

class Detalle extends CI_Controller {

    public function index($producto) {
        
        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->library('carrito');
        
        if (@!$_POST['add']){
        $productos = $this->Productos->DetallesDe($producto);
        $categorias = $this->Productos->Categorias();
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('product-details', array('pro' => $productos), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
        else
        {
        $cuerpo=[];
        $carrito=$this->carrito->introduce_pro($this->input->post('id'), $this->input->post('nombre'), 
                $this->input->post('precio'), $this->input->post('img'), $this->input->post('cant'));        
        $carro=$this->carrito->resumen_carrito();
        
        $cuerpo['d1']=$this->load->view('cart',array('carro'=>$carro), true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
        }
    }

}
