<?php

if (!defined('BASEPATH')){
exit('No direct script access allowed');}

class Correo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('usuarios');
        $this->load->helper('url');
        $this->load->library('session');        
        $this->load->helper('monedas');
    }
/**
 * INICIALIZA LOS DATOS DE CORREO Y LO ENVÍA
 * @param type $id ID DEL USUARIO
 * @param type $token TOKEN PARA CAMBIAR CONTRASEÑA
 * @param type $subject ASUNTO DEL CORREO
 */
    public function cor($id, $token, $subject) {
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'mercaroche@gmail.com';
        $config['smtp_pass'] = 'arochemercado2016';
        $config['smtp_timeout'] = '7';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
        $this->email->initialize($config);

        $us = $this->usuarios->DevuelveDatosUs($id); //COGE LOS DATOS DEL USUARIO
        $correo = $us[0]['mail']; 
        //GENERO EL MENSAJE
        $mensaje = 'Si desea cambiar la contraseña haz click en el siguiente enlace: ' . base_url() . "index.php/Login/cambiarPass/$id/$token";
        $this->EnviaCorreo($correo, $mensaje, $subject); //ENVÍA EL CORREO
    }
/**
 * FORMALIZA UN CORREO Y LO ENVÍA
 * @param type $correo CORREO ELECTRÓNICO
 * @param type $mensaje MENSAJE 
 * @param type $subject ASUNTO
 */
    private function EnviaCorreo($correo, $mensaje, $subject) {

        if ($subject == "cambio"){ //SI EL ASUNTO ES CAMBIO, ESCRIBIR CAMBIO DE CONTRASEÑA
        $asunto = 'Cambio de contraseña';}
        $this->email->from('ventas@mercaroche.com', 'MERCAROCHE');
        $this->email->to($correo);
        $this->email->subject($asunto);
        $this->email->message($mensaje);

        if ($this->email->send()) { //SI EL CORREO SE HA ENVIADO MOSTRAR EL MENSAJE EN LA PLANTILLA
            $cuerpo['d1'] = '<center><P style="color:blue; font-weight:bold;">Se ha enviado un enlace a su correo electrónico<p></center>';
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
        echo $this->email->print_debugger(); 
    }
/**
 * ENVÍA EL RESUMEN DEL PEDIDO AL CORREO ELECTRÓNICO
 * @param type $id
 * @param type $id_ped
 */
    public function EnviarPdf($id, $id_ped) {
        $us = $this->usuarios->DevuelveDatosUs($id); //COGE LOS DATOS DEL USUARIO
        $correo = $us[0]['mail']; //SU CORREO ELECTRÓNICO
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = 'mercaroche@gmail.com';
        $config['smtp_pass'] = 'arochemercado2016';
        $config['smtp_timeout'] = '7';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
        $this->email->initialize($config); //INICIALIZA LAS VARIABLES
        $this->email->from('ventas@mercaroche.com', 'MERCAROCHE');
        $this->email->to($correo);
        $this->email->subject('RESUMEN DE SU PEDIDO');
        $this->email->message('Ha hecho una compra en Mercaroche');
        $this->email->attach('assets/pedidos/pedido.pdf'); //COGE EL PDF QUE SE HA CREADO
        if ($this->email->send()) { //SI SE HA ENVIADO
            $this->session->unset_userdata('comprando'); //ELIMINO COMPRANDO DE LA SESIÓN
            $this->session->unset_userdata('carrito'); //ELIMINO EL CARRITO DE LA SESIÓN
            redirect("/Pedidos/mostrarVentas/$id_ped", 'location', 301); //MUESTRO LAS VENTAS DE ESTE PEDIDO
        }
        echo $this->email->print_debugger();
    }
}
