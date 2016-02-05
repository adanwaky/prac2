<?php
class pedido extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function crearPedido($data){
        $this->db->insert('pedido', $data);
    }
    
    public function UltimoPedido(){
        $qr=$this->db->query('SELECT idPed as id FROM pedido ORDER BY idPed desc limit 1');
        return $qr->result_array();
    }
    
}