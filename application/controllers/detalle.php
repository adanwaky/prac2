<?php
class Detalle extends CI_Controller {

	public function index($producto)
	{
            $this->load->model('Productos');
            $this->load->helper('url');
            $productos = $this->Productos->DetallesDe($producto);                      
            $cuerpo['d1']=$this->load->view('category', '',true);
        $cuerpo['d2']=$this->load->view('product-details', array('pro'=> $productos), true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
        
        }
        
        
}