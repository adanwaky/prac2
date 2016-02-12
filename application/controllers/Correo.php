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
    }

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

        $us = $this->usuarios->DevuelveDatosUs($id);
        $correo = $us[0]['mail'];
        $mensaje = 'Si desea cambiar la contraseña haz click en el siguiente enlace: ' . base_url() . "index.php/Login/cambiarPass/$id/$token";
        $this->EnviaCorreo($correo, $mensaje, $subject);
    }

    private function EnviaCorreo($correo, $mensaje, $subject) {

        if ($subject == "cambio"){
        $asunto = 'Cambio de contraseña';}
        $this->email->from('ventas@mercaroche.com', 'MERCAROCHE');
        $this->email->to($correo);
        $this->email->subject($asunto);
        $this->email->message($mensaje);

        if ($this->email->send()) {
            $cuerpo['d1'] = '<center><P>Se ha enviado un enlace a su correo electrónico<p></center>';
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }

        echo $this->email->print_debugger();
    }

    public function EnviarPdf($id, $id_ped) {
        $us = $this->usuarios->DevuelveDatosUs($id);
        $correo = $us[0]['mail'];
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
        $this->email->from('ventas@mercaroche.com', 'MERCAROCHE');
        $this->email->to($correo);
        $this->email->subject('RESUMEN DE SU PEDIDO');
        $this->email->message('Ha hecho una compra en Mercaroche');
        $this->email->attach('assets/pedidos/pedido.pdf');
        if ($this->email->send()) {
            $this->session->unset_userdata('comprando');
            $this->session->unset_userdata('carrito');
            redirect("/Pedidos/mostrarVentas/$id_ped", 'location', 301);
        }
        echo $this->email->print_debugger();
    }

}
