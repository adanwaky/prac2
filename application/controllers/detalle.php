<?php
class detalle extends CI_Controller {

	public function index($producto)
	{
            $this->load->model('productos');
            $this->load->helper('url');
            $productos = $this->productos->DetallesDe($producto);                      
            $cuerpo['d1']=$this->load->view('category', '',true);
        $cuerpo['d2']=$this->load->view('product-details', array('pro'=> $productos), true);
        $this->load->view('prueba', array('cuerpo'=>$cuerpo));
        
        }
        
        
}