<?php

class provincias extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
/**
 * DEVUELVE UN ARRAY CON LA ID Y EL NOMBRE DE PROVINCIA
 * @return type
 */
    public function arrayprovincias() {
        $qr = $this->db->query('SELECT idPro, nombre FROM provincia');
        $provincias = Array();
        foreach ($qr->result_array() as $row) {
            $provincias[$row['idPro']] = $row['nombre'];
        }
        return $provincias;
    }
    /**
     * DEVUELVE EL NOMBRE DE UNA PROVINCIA
     * @param type $id
     * @return type
     */
    public function devuelveProvincia($id){
        $qr = $this->db->query("select nombre from provincia where idPro='$id'");        
        return $qr->result_array();
    }
}
