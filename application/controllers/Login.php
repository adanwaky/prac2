<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->helper('monedas');
    }
/**
 * CARGA LA VISTA DE LOGIN
 */
    public function index() {
        $provincias = $this->provincias->arrayprovincias(); //COGE LAS PROVINCIAS 
        if (!$this->input->post('login') && !$this->input->post('insc')) { //SI NO SE HA DADO A LOGIN NI INSCRIBIRSE
            //MUESTRA LA VISTA
            $cuerpo['d1'] = $this->load->view('login', array('provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('login')) {//SI SE HA DADO A LOGIN
                $this->SiEsLogin($provincias); 
            }
        }
        if ($this->input->post('insc')) { //SI SE HA DADO A INSCRIBIR
            $this->SiEsInscribir($provincias);
        }
    }
/**
 * DESTRUYE LA SESIÓN
 */
    public function CerrarSesion() {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('comprando');
        $this->session->unset_userdata('carrito');
        redirect('/Welcome/index', 'location', 301); //MUESTRA INICIO
    }
/**
 * 
 * @param type $user
 * @param type $pass
 */
    public function LogeaUser($user, $pass) {
        $this->session->set_userdata(array('login'=>'logueado'));
        $id = $this->usuarios->DevuelveId($user, $pass);
        $this->session->set_userdata(array('user'=>$id[0]['idUsu']));
         $this->session->set_userdata(array('nombreUser'=>$user));
        if ($this->session->userdata('comprando')!=null) {
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
        $provincias = $this->provincias->arrayprovincias();
        $user = $this->usuarios->DevuelveDatosUs($this->session->userdata('user'));
        if (!$this->input->post()) {
            $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('act')) {
                $this->SiEsActualizar($provincias);
            }
            if ($this->input->post('cons')) {
                $this->enviarCorreoPass($this->session->userdata('user'));
            }
            if ($this->input->post('baja')) {
                $this->darBaja($this->session->userdata('user'));
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
        if (!$this->input->post()) {
            $cuerpo['d1'] = $this->load->view('camb_cont', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $tok = $this->generaToken($id, $this->input->post('dni'), $this->input->post('user'));
            $datos = array('pass' => md5($this->input->post('pass')), 'user' => $this->input->post('user'));
            if ($tok == $token) {
                $this->usuarios->ActualizarUsuario($datos);
                redirect(base_url() . '/index.php/Login/index', 'location', 301);
            } else {
                $mensaje = 'DNI o usuario incorrecto';
                $cuerpo['d1'] = $this->load->view('camb_cont', array('mensaje' => $mensaje), true);
                $this->load->view('plantilla', array('cuerpo' => $cuerpo));
            }
        }
    }

    public function ResetPass() {
        if (!$this->input->post()) {
            $cuerpo['d1'] = $this->load->view('pideUser', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $id = $this->usuarios->DevuelveId2($this->input->post('user'));
            $this->enviarCorreoPass($id[0]['idUsu']);
        }
    }

    private function InscripcionOk($usuario, $mail, $pass, $dni, $nombre, $apellidos, $direccion, $cp, $provincia, & $mensaje) {
        $resultado = $this->usuarios->ExisteNombre($usuario, $this->session->userdata('user'));
        if ($usuario == "" || $pass == "" ||
                $nombre == "" || $apellidos == "" || $direccion == "" || $cp == "" || $provincia == "") {
            $mensaje.='Hay campos sin rellenar. <br>';
            return false;
        } elseif ($resultado != null) {
            $mensaje.='El usuario ya existe. <br>';
            return false;
        } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mensaje.='Correo incorrecto. <br>';
            return false;
        } elseif (!$this->dnivalido($dni)) {
            $mensaje.='DNI incorrecto. <br>';
            return false;
        } else {
            return true;
        }
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

    private function darBaja($id) {
        $usuario = $this->usuarios->devuelveDatosUs($id);
        $datos = array('estado' => 'baja', 'user' => $usuario[0]['user']);
        $this->usuarios->ActualizarUsuario($datos);
        $this->CerrarSesion();
    }

    private function SiEsInscribir($provincias) {
        $msj = "";
        if ($this->InscripcionOk($this->input->post('us'), $this->input->post('mail'), $this->input->post('ps'), $this->input->post('DNI'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'), $msj)) {

            $this->Inscribir($this->input->post('DNI'), $this->input->post('us'), md5($this->input->post('ps')), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
            $this->LogeaUser($this->input->post('us'), md5($this->input->post('ps')));
        } else {
            $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $msj, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }

    private function SiEsLogin($provincias) {

        if ($this->usuarios->existeUser($this->input->post('user'), md5($this->input->post('pass')))) {
            $this->LogeaUser($this->input->post('user'), md5($this->input->post('pass')));
        } else {
            $mensaje = 'Nombre de usuario o contraseña incorrecta';
            $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $mensaje, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }
    
    private function SiEsActualizar($provincias){
        $msj = "";
                if ($this->InscripcionOk($this->input->post('us'), $this->input->post('mail'), 'aa', $this->input->post('DNI'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'), $msj)) {
                    $this->ActualizarUser($this->input->post('DNI'), $this->input->post('us'), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
                } else {
                    $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias, 'mensaje' => $msj), true);
                    $this->load->view('plantilla', array('cuerpo' => $cuerpo));
                }
    }

}
