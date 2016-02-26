<?php
class xml extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /**
     * INSERTA UNA CATEGORÍA EN LA BASE DE DATOS
     * @param type $data
     * @return type
     */
    public function mas_categoria($data){
         $this->db->insert('categoria', $data);
         return $this->db->insert_id();
    }
    /**
     * INSERTA UN PRODUCTO EN LA BASE DE DATOS
     * @param type $data
     */
    public function mas_productos($data){
         $this->db->insert('producto', $data);
    }
}