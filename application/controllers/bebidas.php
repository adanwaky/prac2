<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class bebidas extends CI_Controller {

    public function index() {
       /* $this->load->library('pagination');     
        $config['base_url']=
        $config['total_rows'] = '10';
        $config['per_page'] = '6';        
        $this->pagination->initialize($config);
        echo $this->pagination->create_links();*/

        $this->load->model('productos');
         $this->load->helper('url');
        $productos = $this->productos->ProductosDe(4);
        $this->load->view('header');
        $pagina['dato2']=$this->load->view('category','',true);
        $pagina['dato3']=$this->load->view('shop', array('pro'=> $productos), true);
        $this->load->view('mostrar', $pagina);        
        $this->load->view('footer');
          
    }
}
  
