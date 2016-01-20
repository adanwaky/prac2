<?php

class carniceria extends CI_Controller {

    public function index() {
        $this->load->model('productos');
         $this->load->helper('url');
        $productos = $this->productos->ProductosDe(2);
        $this->load->view('header');
        $pagina['dato2']=$this->load->view('category');
        $pagina['dato2']=$this->load->view('shop', array('pro'=> $productos));
        $this->load->view('mostrar', $pagina); 
        $this->load->view('footer');
          
    }
}
  
