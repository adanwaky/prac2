<?php
class pedidos extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function crearVenta($data){
        $this->db->insert('venta', $data);
    }
    
}