<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

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
 * ACTUALIZA, COMPRA O MUESTRA EL CARRITO DEPENDIENDO A LO QUE SE LE DE
 * @param type $mensaje
 */
    public function muestraCart($mensaje = null) {
        if (!$this->input->post('upd') && !$this->input->post('comprar')) { //SI NO VA A ACTUALIZAR Y COMPRAR, MOSTRAR
            $euros = $this->carrito->precio_total();//COGE EL PRECIO TOTAL
            $carro = $this->carrito->get_content();//COGE EL CONTENIDO DEL CARRITO
            //CARGA LA VISTA Y LA MUESTRA
            $cuerpo['d1'] = $this->load->view('cart', array('carro' => $carro, 'euros' => $euros, 'mensaje' => $mensaje), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('upd')) { //SI SE HA DADO A ACTUALIZAR
                $this->actualizar($this->input->post());
            }
            if ($this->input->post('comprar')) { //SI SE HA DADO A COMPRAR
                if (!$this->session->userdata('login')) { //SI NO SE HA LOGUEADO
                   $this->session->set_userdata(array('comprando'=>'comprando')); //GUARDO QUE ESTABA COMPRANDO PARA REDIRECCIONARLO
                    redirect('/Login/index', 'location', 301); //FORMULARIO DE LOGIN
                } else {//SI SE HA LOGUEADO
                    $this->realizarcompra($this->session->userdata('user'));
                }
            }
        }
    }
    
/**
 * METE EN EL CARRITO UN PRODUCTO DÁNDOLE EN AÑADIR AL CARRITO SIN ENTRAR EN DETALLES
 * @param type $id
 * @param type $unidades
 */
    public function guardar($id, $unidades = 1) { 
        $producto = $this->productos->DetallesDe($id);//COGE LOS DATOS DEL PRODUCTO
        $prod = array('id' => $producto[0]['idPro'], //CREA EL ARRAY PARA INTRODUCIRLO EN EL CARRITO
            'nombre' => $producto[0]['nombrePro'],
            'precio' => $producto[0]['precio'],
            'img' => $producto[0]['imagen'],
            'unidades' => $unidades);
        $this->carrito->introduce_pro($prod, $producto[0]['stock']); //LO INTRODUCE
        redirect('/Cart/muestraCart', 'location', 301); //MUESTRA EL CARRITO
    }
/**
 * METE EN EL CARRITO UN PRODUCTO DÁNDOLE EN AÑADIR AL CARRITO ENTRANDO EN VISTA DETALLE
 * @param type $id
 * @param type $unidades
 */
    public function guardarPro($id, $unidades) { 
        $producto = $this->productos->DetallesDe($id);//COGE LOS DATOS DEL PRODUCTO
        $prod = array('id' => $producto[0]['idPro'],//CREA EL ARRAY PARA INTRODUCIRLO EN EL CARRITO
            'nombre' => $producto[0]['nombrePro'],
            'precio' => $producto[0]['precio'],
            'img' => $producto[0]['imagen'],
            'unidades' => $unidades);
        $this->carrito->introduce_pro($prod, $producto[0]['stock']);//LO INTRODUCE
    }
/**
 * BORRA UN PRODUCTO DEL CARRITO
 * @param type $id
 */
    public function borrar($id) {
        $unique_id = md5($id);//CIFRO LA ID
        $this->carrito->remove_producto($unique_id);//BORRO EL PRODUCTO
        redirect('/Cart/muestraCart', 'location', 301);//MUESTRO EL CARRITO
    }
/**
 * ACTUALIZA EL CARRITO
 * @param type $POST
 */
    public function actualizar($POST) {
        foreach ($POST as $key => $value) { //POR CADA PRODUCTO
            if ($value == "" || $value == "Actualizar") {  //SI SE DA ESTE CASO NO HACE NADA              
            } else {
                $producto = $this->productos->DetallesDe($key);//COGE LOS DATOS DE PRODUCTOS
                if ($value > $producto[0]['stock']) { //SI NO HAY SUFICIENTE STOCK
                    $mensaje = 'No hay suficiente stock';
                    redirect("/Cart/muestraCart/$mensaje", 'location', 301); //MUESTRA EL CARRITO Y EL MENSAJE
                } else {//SI HAY SUFICIENTE STOCK
                    $this->guardarPro($key, $value);//LO VUELVE A INTRODUCIR EN EL CARRITO
                }
            }
        }
        redirect('/Cart/muestraCart', 'location', 301); //MUESTRA EL CARRITO
    }
/**
 * CARGA LOS DATOS PARA REALIZAR UNA COMPRA
 */
    public function realizarcompra() {
        $datosUser = $this->usuarios->DevuelveDatosUs($this->session->userdata('user')); //COGE LOS DATOS DEL USUARIO
        $provincia = $this->provincias->DevuelveProvincia($datosUser[0]['provincias_id']); //LA PROVINCIA DEL USUARIO
        $euros = $this->carrito->precio_total();//PRECIO TOTAL DEL CARRITO
        $carro = $this->carrito->get_content();//CONTENIDO DEL CARRITO
        //CARGA LA VISTA DONDE SE MUESTRA EL RESUMEN
        $cuerpo['d1'] = $this->load->view('checkout', array('carro' => $carro, 'euros' => $euros,
            'datos' => $datosUser, 'provincia' => $provincia), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

}
