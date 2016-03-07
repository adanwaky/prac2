<?php

class usuarios extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/**
 * DEVUELVE TRUE O FALSE DEPENDIENDO SI EL USUARIO EXISTE O NO
 * @param type $user
 * @param type $pass
 * @return boolean
 */
    public function existeUser($user, $pass) {
        $qr = $this->db->get_where('usuario', array('pass' => $pass, 'user' => $user, 'estado'=>'alta'))->num_rows();
        if ($qr == 1) {
            $this->session->set_userdata(array('login'=>'login'));
            return true;
        } else {
            return false;
        }
    }
    /**
     * INSERTA UN USUARIO EN LA BASE DE DATOS
     * @param type $data
     */
    public function InsertarUsuario($data)
    {
        $this->db->insert('usuario', $data);
    }
    /**
     * DEVUELVE LOS DATOS DE UN USUARIO
     * @param type $id
     * @return type
     */
    public function DevuelveDatosUs($id){
        $qr = $this->db->query("select * from usuario where idUsu='$id'");        
        return $qr->result_array();
    }
    /**
     * ACTUALIZA LOS DATOS DE UN USUARIO 
     * @param type $data
     */
    public function ActualizarUsuario($data){
       $this->db->update('usuario', $data, array('user' => $data['user']));
    }
    /**
     * ACTUALIZA EL ESTADO DE UN USUARIO A BAJA
     * @param type $id
     */
    public function BajaUsuario($id){
        $this->db->update('usuario', array('estado'=>'baja'), "idUsu = $id");
    }
    /**
     * DEVUELVE LA ID DE UN USUARIO 
     * @param type $user
     * @param type $pass
     * @return type
     */
    public function DevuelveId($user, $pass){
        $qr = $this->db->query("select idUsu from usuario where user='$user' and pass='$pass'");        
        return $qr->result_array();
    }
    /**
     * DEVUELVE LA ID DE UN USUARIO
     * @param type $user
     * @return type
     */
    public function DevuelveId2($user){
        $qr = $this->db->query("select idUsu from usuario where user='$user'");        
        return $qr->result_array();
    }
    /**
     * DEVUELVE LA ID SI EXISTE EL NOMBRE DE USUARIO EN LA BASE DE DATOS DISTINTA DE LA ID
     * @param type $user
     * @param type $id
     * @return type
     */
    public function ExisteNombreAct($user, $id){
        $qr = $this->db->query("select idUsu from usuario where user='$user' and idUsu!=$id");        
        return $qr->result_array();
    }
    
    public function ExisteNombreIns($user){
        $qr = $this->db->query("select idUsu from usuario where user='$user'");        
        return $qr->result_array();
    }

}
