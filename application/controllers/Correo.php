<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correo extends CI_Controller {

   public function cor($id, $token, $subject ) {
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->model('usuarios');
        
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessansebastian.com';
        $config['smtp_pass'] = 'daw2alumno';        
        $this->email->initialize($config);
        
        $us=$this->usuarios->DevuelveDatosUs($id);
       $correo=$us[0]['mail'];
       $mensaje='Si desea cambiar la contraseña haz click en el siguiente enlace: '.base_url()."index.php/Login/cambiarPass/$id/$token";
       $this->EnviaCorreo($correo, $mensaje, $subject);     
       
    }

    private function EnviaCorreo( $correo, $mensaje, $subject) {
       // $this->load->helper('url');
        if($subject=="cambio") $asunto='Cambio de contraseña';
        $this->email->from('ventas@mercaroche.com', 'MERCAROCHE');
        $this->email->to($correo);
        $this->email->subject($asunto);
        $this->email->message($mensaje);
       
                if ( $this->email->send() )
		{
                 $cuerpo['d1'] = '<center><P>Se ha enviado un enlace a su correo electrónico<p></center>';
                $this->load->view('plantilla', array('cuerpo' => $cuerpo));
                //header ('refresh:2; url='.base_url());
		}
        echo $this->email->print_debugger();
    }
}
