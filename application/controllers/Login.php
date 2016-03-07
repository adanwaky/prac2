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
     * GUARDA DATOS NECESARIOS EN LA SESIÓN AL LOGUEARSE
     * @param type $user
     * @param type $pass
     */
    public function LogeaUser($user, $pass) {
        $this->session->set_userdata(array('login' => 'logueado')); //GUARDA LOGUEADO PARA EL PROCESO DE COMPRA
        $id = $this->usuarios->DevuelveId($user, $pass); //BUSCA EL ID DEL USUARIO
        $this->session->set_userdata(array('user' => $id[0]['idUsu'])); //GUARDA EL ID EN LA SESIÓN
        $this->session->set_userdata(array('nombreUser' => $user)); //GUARDA EL NOMBRE DE USUARIO EN LA SESIÓN
        if ($this->session->userdata('comprando') != null) { //SI EXISTE COMPRANDO SIGUE CON LA COMPRA
            redirect('/Cart/realizarcompra', 'location', 301);
        } else { //SI NO EXISTE COMPRANDO
            redirect('/Welcome/index', 'location', 301); //VA AL INDEX
        }
    }

    /**
     * INSERTA UN USUARIO EN LA BASE DE DATOS
     * @param type $dni
     * @param type $us
     * @param type $ps
     * @param type $mail
     * @param type $nombre
     * @param type $apellidos
     * @param type $dir
     * @param type $cp
     * @param type $provincia
     */
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
        $this->usuarios->InsertarUsuario($datos); //INSERTA EL USUARIO EN LA BASE DE DATOS
    }

    /**
     * CONTROLA SI SE ACTUALIZA, CAMBIA LA CONTRASEÑA O SE DA DE BAJA LOS DATOS DE UN USUARIO
     */
    public function datosUser() {

        $provincias = $this->provincias->arrayprovincias(); //BUSCA LAS PROVINCIAS
        $user = $this->usuarios->DevuelveDatosUs($this->session->userdata('user')); //COGE LOS DATOS DEL USUARIO
        if (!$this->input->post()) { //SI NO SE HA ENVIADO NADA CARGA LA VISTA DEL FORMULARIO DE USUARIO
            $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            if ($this->input->post('act')) { //SI SE DA A ACTUALIZAR
                $this->session->set_userdata(array('act_datos' => "act_datos"));
                $this->SiEsActualizar($provincias, $user); //ACTUALIZA EL USUARIO
            }
            if ($this->input->post('cons')) { //SI SE DA A CAMBIAR CONTRASEÑA
                $this->enviarCorreoPass($this->session->userdata('user')); //ENVÍA UN CORREO
            }
            if ($this->input->post('baja')) { //SI SE DA A DARME DE BAJA
                $this->darBaja($this->session->userdata('user')); //DAR BAJA AL USUARIO
            }
        }
    }

    /**
     * ACTUALIZA LOS DATOS DEL USUARIO EN LA BASE DE DATOS
     * @param type $dni
     * @param type $us
     * @param type $mail
     * @param type $nombre
     * @param type $apellidos
     * @param type $dir
     * @param type $cp
     * @param type $provincia
     */
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
        $this->usuarios->ActualizarUsuario($datos); //ACTUALIZA LOS DATOS
        $this->session->unset_userdata('act_datos');
        redirect("/Login/datosUser", 'location', 301); //MUESTRA LOS DATOS DEL USUARIO
    }

    /**
     * CARGA LOS DATOS PARA ENVIAR EL CORREO PARA CAMBIO DE CONTRASEÑA
     * @param type $id
     */
    public function enviarCorreoPass($id) {
        $us = $this->usuarios->DevuelveDatosUs($id); //CARGA LOS DATOS DEL USUARIO        
        $token = $this->generaToken($id, $us[0]['dni'], $us[0]['user']); //GENERA UN TOKEN
        $subject = "cambio"; //ASUNTO
        //VA AL CONTROLADOR DE CORREO PARA ENVIARLO
        redirect("/Correo/cor/$id/$token/$subject", 'location', 301);
    }

    /**
     * GENERA UN TOKEN PARA ENVIARLO CON EL CAMBIO DE CONTRASEÑA
     * @param type $id
     * @param type $dni
     * @param type $user
     * @return type
     */
    private function generaToken($id, $dni, $user) {
        $token = sha1($id . $dni . $user); //CIFRA EL ID, EL DNI Y EL NOMBRE DEL USUARIO
        return $token;
    }

    /**
     * CAMBIA LA CONTRASEÑA SI NO HAY ERRORES
     * @param type $id
     * @param type $token
     */
    public function cambiarPass($id, $token) {
        if (!$this->input->post()) { //SI NO SE HA ENVIADO NADA MUESTRA EL FORMULARIO
            if (!$this->session->userdata('moneda')) { //SI NO EXISTE LA SESIÓN MONEDA LA CREA
                $this->session->set_userdata(array('moneda' => 'EUR', 'tarifa' => 1));
            }
            $cuerpo['d1'] = $this->load->view('camb_cont', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            //GENERO EL TOKEN CON LOS DATOS DEL INPUT
            $tok = $this->generaToken($id, $this->input->post('dni'), $this->input->post('user'));
            if ($tok == $token) { //SI COINCIDE CON EL TOKEN QUE SE LE HA PASADO
                $datos = array('pass' => md5($this->input->post('pass')), 'user' => $this->input->post('user'));
                $this->usuarios->ActualizarUsuario($datos); //ACTUALIZA LA CONTRASEÑA EL USUARIO
                redirect(base_url() . '/index.php/Login/index', 'location', 301); //VA A LOGIN
            } else { //SI NO COINCIDE
                $mensaje = 'DNI o usuario incorrecto';
                //CARGA LA VISTA DE ENUEVO Y MUESTRA EL MENSAJE
                $cuerpo['d1'] = $this->load->view('camb_cont', array('mensaje' => $mensaje), true);
                $this->load->view('plantilla', array('cuerpo' => $cuerpo));
            }
        }
    }

    /**
     * SI SE OLVIDA LA CONTRASEÑA
     */
    public function ResetPass() {
        if ($this->input->post('user')=="") {//SI NO SE HA ENVIADO NADA
            //MUESTRA PEDIR USUARIO
            $cuerpo['d1'] = $this->load->view('pideUser', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $id = $this->usuarios->DevuelveId2($this->input->post('user')); //BUSCA LA ID DEL USUARIO
           if(empty($id)){
               $cuerpo['d1'] = $this->load->view('pideUser', array('mensaje'=>'Usuario incorrecto'), true);
                $this->load->view('plantilla', array('cuerpo' => $cuerpo));
           }else{
            $this->enviarCorreoPass($id[0]['idUsu']); //ENVIA EL CORREO 
            }
        }
    }

    /**
     * FILTRA LOS DATOS DE INSCRIPCIÓN Y CAMBIA MENSAJE DEPENDIENDO DEL CASO
     * @param type $usuario
     * @param type $mail
     * @param type $pass
     * @param type $dni
     * @param type $nombre
     * @param type $apellidos
     * @param type $direccion
     * @param type $cp
     * @param type $provincia
     * @param type $mensaje
     * @return boolean
     */
    private function InscripcionOk($usuario, $mail, $pass, $dni, $nombre, $apellidos, $direccion, $cp, $provincia, & $mensaje) {
        if ($this->session->userdata('act_datos')) {
            $resultado = $this->usuarios->ExisteNombreAct($usuario, $this->session->userdata('user'));
        } else {
            $resultado = $this->usuarios->ExisteNombreIns($usuario);
        }
        //MIRA SI EXISTE EL NOMBRE DE USUARIO EN LA BASE DE DATOS
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

    /**
     * FILTRA UN DNI
     * @param type $dni
     * @return boolean
     */
    private function dnivalido($dni) {
        $letra = strtoupper(substr($dni, -1));

        $numeros = substr($dni, 0, -1);
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * CAMBIA EL ESTADO A BAJA DE UN USUARIO
     * @param type $id
     */
    private function darBaja($id) {
        $usuario = $this->usuarios->devuelveDatosUs($id); //COGE LOS DATOS DE UN USUARIO
        $datos = array('estado' => 'baja', 'user' => $usuario[0]['user']);
        $this->usuarios->ActualizarUsuario($datos); //ACTUALIZA EL ESTADO
        $this->CerrarSesion(); //CIERRA LA SESIÓN
    }

    /**
     * SI SE LE HA DADO A INSCRIBIR
     * @param type $provincias
     */
    private function SiEsInscribir($provincias) {
        $msj = "";
        if ($this->InscripcionOk($this->input->post('us'), $this->input->post('mail'), $this->input->post('ps'), $this->input->post('DNI'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'), $msj)) {
            //SI LOS DATOS SON CORRECTOS, INSERTA EL USUARIO EN LA BASE DE DATOS Y LO LOGUEA
            $this->Inscribir($this->input->post('DNI'), $this->input->post('us'), md5($this->input->post('ps')), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
            $this->LogeaUser($this->input->post('us'), md5($this->input->post('ps')));
        } else {//SI LOS DATOS SON INCORRECTOS MUESTRA LA VISTA DE LOGIN DE NUEVO CON UN MENSAJE
            $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $msj, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }

    /**
     * SI SE LE HA DADO A LOGIN
     * @param type $provincias
     */
    private function SiEsLogin($provincias) {

        if ($this->usuarios->existeUser($this->input->post('user'), md5($this->input->post('pass')))) {
            //SI LOS DATOS SON CORRECTOS, LO LOGUEA
            $this->LogeaUser($this->input->post('user'), md5($this->input->post('pass')));
        } else {//SI NO SON CORRECTOS, MUESTRA LA VISTA DE NUEVO CON UN MENSAJE
            $mensaje = 'Nombre de usuario o contraseña incorrecta';
            $cuerpo['d1'] = $this->load->view('login', array('mensaje' => $mensaje, 'provincias' => $provincias), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }

    /**
     * SI SE LE HA DADO A ACTUALIZAR
     * @param type $provincias
     */
    private function SiEsActualizar($provincias, $user) {
        $msj = "";
        if ($this->InscripcionOk($this->input->post('us'), $this->input->post('mail'), 'aa', $this->input->post('DNI'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'), $msj)) {
            //SI LOS DATOS SON CORRECTOS, ACTUALIZA LOS DATOS EN LA BASE DE DATOS 
            $this->ActualizarUser($this->input->post('DNI'), $this->input->post('us'), $this->input->post('mail'), $this->input->post('nombre'), $this->input->post('apellidos'), $this->input->post('dir'), $this->input->post('cp'), $this->input->post('provincias_id'));
        } else {
            //SI NO MUESTRA LA VISTA DE NUEVO CON UN MENSAJE
            $cuerpo['d1'] = $this->load->view('form_usuario', array('user' => $user, 'provincias' => $provincias, 'mensaje' => $msj), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }

}
