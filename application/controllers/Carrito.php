<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends CI_Controller {
    
    public function index()
    {
        $this->load->helper('url');        
        $cuerpo['d1']=$this->load->view('cart','', true);
        $this->load->view('plantilla', array('cuerpo'=>$cuerpo));
    }
    
}