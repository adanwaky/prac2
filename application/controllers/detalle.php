<?php
class detalle extends CI_Controller {

	public function index($producto)
	{
            $this->load->model('productos');
            $this->load->helper('url');
            $productos = $this->productos->DetallesDe($producto);                      
            $this->load->view('header');   
           
            $pagina['dato1']=$this->load->view('category', '',true);
            $pagina['dato2']=$this->load->view('product-details', array('pro'=>$productos), true);
            $this->load->view('mostrar', $pagina);             
            $this->load->view('footer');
        
        }
        
        
}