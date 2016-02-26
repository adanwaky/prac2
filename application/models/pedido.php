<?php
class pedido extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /**
     * INSERTA UN PEDIDO EN LA BASE DE DATOS
     * @param type $data
     */
    public function crearPedido($data){
        $this->db->insert('pedido', $data);
    }
    /**
     * DEVUELVE EL ÚLTIMO PEDIDO INSERTADO
     * @return type
     */
    public function UltimoPedido(){
        $qr=$this->db->query('SELECT idPed as id FROM pedido ORDER BY idPed desc limit 1');
        return $qr->result_array();
    }
    /**
     * DEVUELVE LA ID Y EL ESTADO DE LOS PEDIDOS DE UN USUARIO
     * @param type $usuario
     * @return type
     */
    public function pedidosDe($usuario){
        $qr=$this->db->query("SELECT idPed, estado FROM pedido where Usuario_idUsu=$usuario");
        return $qr->result_array();
    }
    /**
     * DEVUELVE LAS VENTAS DE UN PEDIDO
     * @param type $id_pedido
     * @return type
     */
    public function ventas($id_pedido){
        $qr=$this->db->query("SELECT * FROM venta where Pedido_idPed=$id_pedido");
        return $qr->result_array();
    }
    /**
     * ACTUALIZA LOS DATOS DE UN PEDIDO
     * @param type $data
     */
    public function actualizarPedido($data){
         $this->db->update('pedido', $data, array('idPed' => $data['idPed']));
    }
    /**
     * DEVUELVE LOS DATOS DE UN PEDIDO
     * @param type $id
     * @return type
     */
    public function pedidonum($id){
        $qr=$this->db->query("SELECT * FROM pedido where idPed=$id");
        return $qr->result_array();
    }
    /**
     * DEVUELVE LA ID DEL USUARIO QUE HA HECHO UN PEDIDO
     * @param type $idPedido
     * @return type
     */
    public function UsuarioDePedido($idPedido){
        $qr=$this->db->query("SELECT Usuario_idUsu FROM pedido where idPed=$idPedido");
        return $qr->result_array();
    }
    
}