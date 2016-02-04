<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correo extends CI_Controller {

    function index($correo, $mensaje, $subject) {
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.iessansebastian.com';
        $config['smtp_user'] = 'aula4@iessansebastian.com';
        $config['smtp_pass'] = 'daw2alumno';

        $this->email->initialize($config);

        echo "<h1>\n--- CON SMTP y cuenta en servidor externo ---\n</h1>";
        $this->EnviaCorreo($correo, $mensaje);
    }

    private function EnviaCorreo($correo, $mensaje, $subject) {
        $this->email->from('ventas@mercaroche.com');
        $this->email->to($correo);

        $this->email->subject($subject);
        $this->email->message($mensaje);
        echo $this->email->print_debugger();
    }

}
