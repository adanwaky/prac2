<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agregador extends CI_Controller {

    public function __construct() {
        parent::__construct();

           $this->load->model('tiendas_model');
    }

    public function index()
    {
        $this->load->view('agregador_template', array(
                'tmpl_titulo'=>'Agregador tiendas - Página Inicio',
                'tmpl_menu'=>$this->load->view('agregador_menu', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                'tmpl_encabezado'=>'<h1>Inicio</h1>',
                'tmpl_cuerpo'=>$this->load->view('agregador_inicio', 0, TRUE),
                //'tmpl_script'=>'',            
        ));
    }


    public function tienda($tienda_id , $offset=0)
    {      
        $tienda=$this->tiendas_model->Get($tienda_id);
        $this->load->view('agregador_template', array(
                'tmpl_titulo'=>'Agregador tiendas - Página Inicio',
                'tmpl_menu'=>$this->load->view('agregador_menu', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                'tmpl_encabezado'=>'<h1>Mostrando tienda: '. $tienda->name.'</h1>',
                'tmpl_cuerpo'=>$this->CargaInfoTienda($tienda,$offset),
                //'tmpl_script'=>'',            
        ));
    }

    private function CargaInfoTienda($tienda, $offset)
    {
        $nProductosxPagina=3;
        
        $this->load->library('JSON_WebClient');
     
        $this->json_webclient->SetURL($tienda->URL);
        $this->json_webclient->Debug($this->session->userdata('depurar'));
        
        $nProductos=$this->json_webclient->Call('Total', array());
        
        if ($this->json_webclient->IsLastCallOk())
        {
            $listaProductos=$this->json_webclient->Call('Lista', array($offset, $nProductosxPagina));
            //print_r($listaProductos);
            if ($this->json_webclient->IsLastCallOk())
            {
                $html="";
                foreach($listaProductos as $producto)
                {
                    $html.="<div><h3>".$producto['nombre'].'</h3>';
                    $html.='<div><img src="'.$producto['img'].'"/></div>';
                    $html.="<div>".$producto['descripcion']."</div>";
                    $html.="<div>Precio: ".$producto['precio'].' <a href="'.$producto['url'].'">Comprar</a></div>';
                }
                
                //
                // Paginador
                //
                $this->load->library('pagination');

                $config['uri_segment'] = 4;
                $config['base_url'] = site_url('agregador/tienda/'.$tienda->id);
                $config['total_rows'] = $nProductos;
                $config['per_page'] = $nProductosxPagina; 

                $this->pagination->initialize($config); 

                $html.=
                    '<div style="margin:1em; border:1px solid #ddd; border-radiux:5px; padding:.3em; font-size:1.4em; width:20em; text-align:center">'.
                        $this->pagination->create_links().
                    '</div>';
                
                return $html;
            }
        }
        // Si llega aquí hay error
        return "<h2>ERROR en comunicación</h2>".
                   "<pre>".$this->json_webclient->DescError()."</pre>"; 
    }
    
    /**
     * Muestra la lista de tiendas registradas
     */
    public function Lista()
    {
        $this->load->view('agregador_template', array(
                'tmpl_titulo'=>'Agregador tiendas - Lista de tiendas',
                'tmpl_menu'=>$this->load->view('agregador_menu', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                'tmpl_encabezado'=>'<h1>Agregador - Lista de tiendas</h1>',
                'tmpl_cuerpo'=>$this->load->view('agregador_listatiendas', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                //'tmpl_script'=>'',            
        ));            
    }

    public function Registra()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Nombre', 'required|min_length[3]');
        $this->form_validation->set_rules('info', 'info', '');
        $this->form_validation->set_rules('URL', 'URL', 'required');

        if($this->form_validation->run() === FALSE){
            $this->load->view('agregador_template', array(
                'tmpl_titulo'=>'Agregador tiendas - Registro Tienda',
                'tmpl_menu'=>$this->load->view('agregador_menu', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                'tmpl_encabezado'=>'<h1>Agregador - Registro Tienda</h1>',
                'tmpl_cuerpo'=>$this->load->view('agregador_registro', 0, TRUE),
                //'tmpl_script'=>'',            
            ));                
        }
        else
        {
            // Guardamos datos
            $this->tiendas_model->Add(
                    $this->input->post('name'), 
                    $this->input->post('info'),
                    $this->input->post('URL'));
            redirect('agregador/lista');
        }

    }

    /**
     * Muestra la lista de tiendas registradas
     */
    public function ListaParaBorrar()
    {
        $this->load->view('agregador_template', array(
                'tmpl_titulo'=>'Agregador tiendas - Borrar tiendas',
                'tmpl_menu'=>$this->load->view('agregador_menu', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                'tmpl_encabezado'=>'<h1>Agregador - Lista de tiendas</h1>',
                'tmpl_cuerpo'=>$this->load->view('agregador_borrar_lista', 
                        array('listaTiendas'=>$this->tiendas_model->Lista()), TRUE),
                //'tmpl_script'=>'',            
        ));            
    }  

    /**
     * Borra la tienda seleccionada
     * @param type $id
     */
    public function Borra($id)
    {
        $this->tiendas_model->Remove($id);
        $this->tiendas_model->Save();
        redirect('agregador/listaparaborrar');
    }
    
    public function Depurar($depurar)
    {
        $this->session->set_userdata('depurar', $depurar);
        $this->index();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */