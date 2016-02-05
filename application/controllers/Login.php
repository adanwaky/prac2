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
            $msj = "";
            if ($this->InscipcionOk($this->input->post('us'), $this->input->post('mail'), $this->input->post('ps'), $this->input->post('DNI'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'), $msj)) {

                $this->Inscribir($this->input->post('DNI'), $this->input->post('us'), md5($this->input->post('ps')), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
                $this->LogeaUser($this->input->post('us'), md5($this->input->post('ps')));
            } else {
                $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $msj, 'provincias' => $provincias), true);
                $this->load->view('plantilla', array('cuerpo' => $cuerpo));
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
        $_SESSION['nombreUser'] = $user;
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
        if (!$_POST) {
            $provincias = $this->provincias->arrayprovincias();
            $user = $this->usuarios->DevuelveDatosUs($_SESSION['user']);
            $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($_POST['act']) {
                $this->ActualizarUser($this->input->post('DNI'), $this->input->post('us'), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
            }
            if ($_POST['cons']) {
                $this->enviarCorreoPass($_SESSION['user']);
            }
            if($_POST['baja']){
                $this->darBaja($_SESSION['user']);
            }
        }
    }

    private function ActualizarUser($dni, $us, $mail, $nombre, $apellidos, $dir, $cp, $provincia) {
        $datos = array('dni' => $dni,
            'user' => $us,
            'mail' => $mail,
            'nombreUs' => $nombre,
            'apellidos' => $apellidos,
            'direccion' => $dir,
            'cp' => $cp,
            'estado' => 'alta',
            'provincias_id' => $provincia);
        $this->usuarios->ActualizarUsuario($datos);
        redirect("/Login/datosUser", 'location', 301);
    }

    public function enviarCorreoPass($id) {
        $this->load->helper('url');
        $this->load->model('usuarios');
        $us = $this->usuarios->DevuelveDatosUs($id);
        $token = $this->generaToken($id, $us[0]['dni'], $us[0]['user']);
        $subject = "cambio";
        redirect("/Correo/cor/$id/$token/$subject", 'location', 301);
    }

    private function generaToken($id, $dni, $user) {
        $token = sha1($id . $dni . $user);
        return $token;
    }

    public function cambiarPass($id, $token) {
        $this->load->helper('url');
        if (!$_POST) {
            $cuerpo['d1'] = $this->load->view('camb_cont', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $this->load->model('usuarios');
            $tok = $this->generaToken($id, $_POST['dni'], $_POST['user']);
            $datos = array('pass' => md5($_POST['pass']), 'user' => $_POST['user']);
            if ($tok == $token) {
                $this->usuarios->ActualizarUsuario($datos);
                redirect(base_url() . '/index.php/Login/index', 'location', 301);
            } else {
                echo 'error';
            }
        }
    }

    public function ResetPass() {
        if (!$_POST) {
            $this->load->helper('url');
            $cuerpo['d1'] = $this->load->view('pideUser', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $this->load->model('usuarios');
            $id = $this->usuarios->DevuelveId2($_POST['user']);
            $this->enviarCorreoPass($id[0]['idUsu']);
        }
    }

    private function InscipcionOk($usuario, $mail, $pass, $dni, $nombre, $apellidos, $direccion, $cp, $provincia, & $mensaje) {
        $this->load->model('usuarios');
        $resultado = $this->usuarios->DevuelveId2($usuario);
        if ($usuario == "" || $pass == "" ||
                $nombre == "" || $apellidos == "" || $direccion == "" || $cp == "" || $provincia == "") {
            $mensaje.='Hay campos sin rellenar. <br>';
            return false;
        }

        elseif ($resultado != null) {
            $mensaje.='El usuario ya existe. <br>';
            return false;
        }

        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mensaje.='Correo incorrecto. <br>';
            return false;
        }

        elseif (!$this->dnivalido($dni)) {
            $mensaje.='DNI incorrecto. <br>';
            return false;
        }        
        else{return true;}
    }

    private function dnivalido($dni) {
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
            return true;
        } else {
            return false;
        }
    }
    
    private function darBaja($id){
        $this->load->model('usuarios');
        $usuario=  $this->usuarios->devuelveDatosUs($id);
        $datos=array('estado'=>'baja', 'user'=>$usuario[0]['user'] );
        print_r($datos);
       $this->usuarios->ActualizarUsuario($datos);
       $this->CerrarSesion();
    }

}
