<?php

class usuarios extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function existeUser($user, $pass) {
        $qr = $this->db->get_where('usuario', array('pass' => $pass, 'nombreUs' => $user))->num_rows();
        if ($qr == 1) {
            $_SESSION['login'] = "login";
            return true;
        } else {
            return false;
        }
    }
    
    public function InsertarUsuario($data)
    {
        $this->db->insert('usuario', $data);
    }
    
    public function DevuelveDatosUs($id){
        $qr = $this->db->query("select * from usuario where idUsu='$id'");        
        return $qr->result_array();
    }
    
    public function ActualizarUsuario($data){
       $this->db->update('usuario', $data, array('user' => $data['user']));
    }
    
    public function BajaUsuario($id){
        $this->db->update('usuario', array('estado'=>'baja'), "idUsu = $id");
    }
    
    public function DevuelveId($user, $pass){
        $qr = $this->db->query("select idUsu from usuario where user='$user' and pass='$pass'");        
        return $qr->result_array();
    }

}