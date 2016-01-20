<?php

class productos extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function ProductosDestacados()
    {
        $qr = $this->db->query('select * from producto where se_muestra=1');        
        return $qr->result_array();
    }
    
    public function ProductosDe($categoria)
    {
        $qr = $this->db->query("select * from producto where Categoria_idCat=$categoria");        
        return $qr->result_array();
    }
    
    public function DetallesDe($producto)
    {
        $qr = $this->db->query("select * from producto where idPro=$producto");        
        return $qr->result_array();
    }
    
}