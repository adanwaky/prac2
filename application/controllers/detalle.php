<?php

class Detalle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->library('carrito');
        $this->load->model('productos');
        $this->load->helper('monedas');
    }
/**
 * MUESTRA LOS DETALLES DE UN PRODUCTO
 * @param type $id
 */
    public function index($id) {
        $this->iniciar();//INICIO LAS SESIÓN DE MONEDA
        $producto = $this->productos->DetallesDe($id); //COGE LOS DATOS DEL PRODUCTO
        if ($producto == null) { //SI NO EXISTE
           $cuerpo['d1']=$this->load->view('404', '', true); //MOSTRAR VISTA ERROR 404
           $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else { //SI EXISTE
            if (@!$this->input->post('add')) { //SI NO SE LE HA DADO A AÑADIR AL CARRITO
                $this->mostrarDetalle($id, $producto); //MUESTRA LA VISTA
            } else { //SE HA DADO A AÑADIR AL CARRITO                
                if ($this->input->post('cant') < 0 || $this->input->post('cant') > $producto[0]['stock']) {
                    //SI LA CANTIDAD QUE SE PIDE ES NEGATIVA O MAYOR QUE EL STOCK
                    $producto[0]['pasado'] = 1; //PASO ESTE VALOR PARA MOSTRAR EN LA VISTA UN MENSAJE
                    $this->mostrarDetalle($id,$producto); //VUELVE A CARGAR LA VISTA               
                } else { //SI HAY STOCK
                    $this->guardar($id, $producto); //LO INTRODUCE EN EL CARRITO
                }
            }
        }
    }
    /**
     * INICIALIZA LA SESIÓN MONEDA
     */
    public function iniciar(){
        if (!isset($_SESSION['moneda'])) {
            $this->session->set_userdata(array('moneda'=>'EUR', 'tarifa'=>1));
        }   
    }
/**
 * MUESTRA LA VISTA DETALLE DE UN PRODUCTO
 * @param type $producto PRODUCTO 
 */
    public function mostrarDetalle( $id, $producto) {
        $categorias = $this->productos->Categorias();
        $cuerpo['d1'] = $this->load->view('category', array('cat' => $categorias), true);
        $cuerpo['d2'] = $this->load->view('product-details', array('pro' => $producto), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }
/**
 * METE UN PRODUCTO EN EL CARRITO
 * @param type $id
 * @param type $producto
 */
    public function guardar($id, $producto) {
        $carrito = array('id' => $id, //CREA EL ARRAY CON LOS DATOS PARA EL CARRITO
            'nombre' => $producto['0']['nombrePro'],
            'precio' => $producto['0']['precio'],
            'img' => $producto['0']['imagen'],
            'unidades' => $this->input->post('cant'));
        $this->carrito->introduce_pro($carrito);
        redirect('/Cart/muestraCart', 'location', 301); //MUESTRA EL CARRITO
    }

}
