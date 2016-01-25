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
        $carrito= array('id' =>$this->input->post('id'),
            'nombre' =>$this->input->post('nombre'), 
            'precio' =>$this->input->post('precio'),
            'img' =>  $this->input->post('img'),
            'unidades'=>$this->input->post('cant'));
        
        $this->carrito->introduce_pro($carrito);
        $carro=$_SESSION['carrito'];
      
        //$carro=$this->carrito->resumen_carrito();
        
        $cuerpo['d1']=$this->load->view('cart',array('carro'=>$carro), true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
        }
    }

}
