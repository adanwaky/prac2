<?php

class productos extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function ProductosDestacados()
    {
        $qr = $this->db->query('select * from producto '
                . 'where destacado=1 '
                . 'and (curdate()<=fec_fin and curdate()>=fec_ini);');        
        return $qr->result_array();
    }
    
    public function ProductosDe($categoria, $page, $per_page)
    {
        $qr = $this->db->get_where('producto', array('Categoria_idCat'=>$categoria, 'se_muestra'=>1), $per_page,$page);
        return $qr->result_array();
    }
    
    public function DetallesDe($producto)
    {
        $qr = $this->db->query("select * from producto where idPro=$producto");        
        return $qr->result_array();
    }
    
    public function num_filas($categoria)
    {
        return $this->db->get_where('producto', array('Categoria_idCat'=>$categoria, 'se_muestra'=>1))->num_rows();
    }
    
    public function Categorias()
    {
        $qr = $this->db->query('select * from categoria '
                . 'where se_muestra=1;');        
        return $qr->result_array();
    }
    
    public function DisminuyeStock($id, $data){
         $this->db->update('producto', $data, array('idPro' => $id));
    }
    
    public function num_filas_tot(){
       return $this->db->get_where('producto')->num_rows();
    }
    
    public function TodosProductos($page, $per_page){
        
        $qr = $this->db->query('select * from producto '
                . "where idPro>0 and stock>0 LIMIT $page, $per_page;");
        return $qr->result_array(); 
    }
    public function ProductosDeCat($categoria)
    {
        $qr = $this->db->get_where('producto', array('Categoria_idCat'=>$categoria));
        return $qr->result_array();
    }
    public function devuelveStock($id){
        $qr = $this->db->query("select stock from producto where idPro=$id");
        return $qr->result_array(); 
    }
    
}