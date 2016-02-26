<?php
class ventas extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /**
     * INSERTA UNA VENTA EN LA BASE DE DATOS
     * @param type $data
     */
    public function crearVenta($data){
        $this->db->insert('venta', $data);
    }
    
}