<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $provincias = $this->provincias->arrayprovincias();

        if (!$this->input->post('login') && !$this->input->post('insc')) {
            $cuerpo['d1'] = $this->load->view('login', array('provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('login')) {
                if ($this->usuarios->existeUser($this->input->post('user'), md5($this->input->post('pass')))) {
                    $this->LogeaUser($this->input->post('user'), md5($this->input->post('pass')));
                } else {
                    $mensaje = 'Nombre de usuario o contraseña incorrecta';
                    $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $mensaje, 'provincias' => $provincias), true);
                    $this->load->view('plantilla', array('cuerpo' => $cuerpo));
                }
            }
        }
        if ($this->input->post('insc')) {
//No repetir nombres de usuarios 
            $this->Inscribir($this->input->post('DNI'), $this->input->post('us'), md5($this->input->post('ps')), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
            $_SESSION['login'] = 'logueado';
            if (isset($_SESSION['comprando'])) {
                redirect('/Cart/realizarcompra', 'location', 301);
            } else {
                redirect('/Welcome/index', 'location', 301);
            }
        }
    }

    public function CerrarSesion() {
        $this->load->library('session');
        $this->load->helper('url');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('comprando');
        $this->session->unset_userdata('carrito');
        redirect('/Welcome/index', 'location', 301);
    }

    public function LogeaUser($user, $pass) {

        $_SESSION['login'] = 'logueado';
        $id = $this->usuarios->DevuelveId($user, $pass);
        $_SESSION['user'] = $id[0]['idUsu'];
        $_SESSION['nombreUser']=$user;
       if (isset($_SESSION['comprando'])) {
            redirect('/Cart/realizarcompra', 'location', 301);
        } else {
            redirect('/Welcome/index', 'location', 301);
        }
    }

    public function Inscribir($dni, $us, $ps, $mail, $nombre, $apellidos, $dir, $cp, $provincia) {
        $datos = array('dni' => $dni,
            'user' => $us,
            'pass' => $ps,
            'mail' => $mail,
            'nombreUs' => $nombre,
            'apellidos' => $apellidos,
            'direccion' => $dir,
            'cp' => $cp,
            'estado' => 'alta',
            'provincias_id' => $provincia);
        $this->usuarios->InsertarUsuario($datos);
    }

    public function datosUser() {
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $provincias = $this->provincias->arrayprovincias();
        $user = $this->usuarios->DevuelveDatosUs($_SESSION['user']);
        $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function ActualizarUser($dni, $us, $ps, $mail, $nombre, $apellidos, $dir, $cp, $provincia) {
        $datos = array('dni' => $dni,
            'user' => $us,
            'pass' => $ps,
            'mail' => $mail,
            'nombreUs' => $nombre,
            'apellidos' => $apellidos,
            'direccion' => $dir,
            'cp' => $cp,
            'estado' => 'alta',
            'provincias_id' => $provincia);
        $this->usuarios->ActualizarUsuario($datos);
    }

    public function cambiarContraseña() {
        
    }

}
