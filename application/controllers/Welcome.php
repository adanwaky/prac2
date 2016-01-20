<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
            $this->load->model('productos');
            $this->load->helper('url');
            $productos = $this->productos->ProductosDestacados();
            $cuerpo['d1']=$this->load->view('category', '',true);
            $cuerpo['d2']=$this->load->view('index', array('pro'=>$productos), true);
            $this->load->view('prueba', array('cuerpo'=>$cuerpo));
            
            
           /* $this->load->view('header');     
           // $pagina['dato0']=$this->load->view('slider'); 
            $pagina['dato1']=$this->load->view('category', '',true);
            $pagina['dato2']=$this->load->view('index', array('pro'=>$productos), true);
            $this->load->view('mostrar', $pagina);  
             $this->load->view('footer');*/
             
            //  $this->load->model('provincias');
         //  $this->load->helper('form');
        // $prov = $this->provincias->arrayprovincias();
           // $pagina['dato2']=$this->load->view('shop', array('pro'=> $productos));
           // $pagina['dato3']=$this->load->view('product-details', array('pro'=> $productos[0]));
          // $pagina['dato3']=$this->load->view('checkout',array('provincias' => $prov) );
          //  $pagina['dato3']=$this->load->view('form_usuario', array('provincias'=>$prov));
        //$pagina['dato3']=$this->load->view('login');
        //$pagina['dato3']=$this->load->view('cart');
                       
               // $this->load->view('index', array('pro'=>$productos));
	}
       
}
