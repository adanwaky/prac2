<?php

class productos extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function ProductosDestacados()
    {
        $qr = $this->db->query('select * from producto '
                . 'where se_muestra=1 '
                . 'and (curdate()<=fec_fin and curdate()>=fec_ini) ;');        
        return $qr->result_array();
    }
    
    public function ProductosDe($categoria, $page, $per_page)
    {
        $qr = $this->db->get_where('producto', array('Categoria_idCat'=>$categoria), $per_page,$page);
        return $qr->result_array();
    }
    
    public function DetallesDe($producto)
    {
        $qr = $this->db->query("select * from producto where idPro=$producto");        
        return $qr->result_array();
    }
    
    public function num_filas($categoria)
    {
        return $this->db->get_where('producto', array('Categoria_idCat'=>$categoria))->num_rows();
    }
    
}