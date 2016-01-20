<?php

class Categoria extends CI_Controller {

    
    public function mostrar($categoria)
    {
        $this->load->model('productos');
         $this->load->helper('url');
        $productos = $this->productos->ProductosDe($categoria);
        $cuerpo['d1']=$this->load->view('category', '',true);
        $cuerpo['d2']=$this->load->view('shop', array('pro'=> $productos), true);
        $this->load->view('prueba', array('cuerpo'=>$cuerpo));
    }
    
}

