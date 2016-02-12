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
    
    public function pedidosDe($usuario){
        $qr=$this->db->query("SELECT idPed, estado FROM pedido where Usuario_idUsu=$usuario");
        return $qr->result_array();
    }
    
    public function ventas($id_pedido){
        $qr=$this->db->query("SELECT * FROM venta where Pedido_idPed=$id_pedido");
        return $qr->result_array();
    }
    
    public function actualizarPedido($data){
         $this->db->update('pedido', $data, array('idPed' => $data['idPed']));
    }
    
    public function pedidonum($id){
        $qr=$this->db->query("SELECT * FROM pedido where idPed=$id");
        return $qr->result_array();
    }
    
}