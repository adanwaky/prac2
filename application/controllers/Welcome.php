<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
	public function index()
	{    $this->load->library('pagination');
        $this->load->model('Productos');
            $this->load->helper('url');
            
            $productos = $this->Productos->ProductosDestacados();
            $cuerpo['d1']=$this->load->view('category', '',true);
            $cuerpo['d2']=$this->load->view('index', array('pro'=>$productos), true);
            $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
	}
       
}
