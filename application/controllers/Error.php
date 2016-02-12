<?php

class Error extends CI_Controller {
    public function index(){
        $this->load->helper('url');
        
        $cuerpo['d1']=$this->load->view('404', '', true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }
}
