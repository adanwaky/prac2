<?php
class xml extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function mas_categoria($data){
         $this->db->insert('categoria', $data);
         return $this->db->insert_id();
    }
    
    public function mas_productos($data){
         $this->db->insert('producto', $data);
    }
}