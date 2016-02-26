<?php

class productos extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /**
     * DEVUELVE LOS PRODUCTOS DESTACADOS
     * @return type
     */
    public function ProductosDestacados()
    {
        $qr = $this->db->query('select * from producto '
                . 'where destacado=1 '
                . 'and (curdate()<=fec_fin and curdate()>=fec_ini);');        
        return $qr->result_array();
    }
    /**
     * DEVUELVE LOS PRODUCTOS DE UNA CATEGORÍA PARA LA PAGINACIÓN
     * @param type $categoria
     * @param type $page
     * @param type $per_page
     * @return type
     */
    public function ProductosDe($categoria, $page, $per_page)
    {
        $qr = $this->db->get_where('producto', array('Categoria_idCat'=>$categoria, 'se_muestra'=>1), $per_page,$page);
        return $qr->result_array();
    }
    /**
     * DEVUELVE LOS DATOS DE UN PRODUCTO
     * @param type $producto
     * @return type
     */
    public function DetallesDe($producto)
    {
        $qr = $this->db->query("select * from producto where idPro=$producto");        
        return $qr->result_array();
    }
    /**
     * DEVUELVE EL NÚMERO DE CATEGORÍAS QUE SE MUESTRAN
     * @param type $categoria
     * @return type
     */
    public function num_filas($categoria)
    {
        return $this->db->get_where('producto', array('Categoria_idCat'=>$categoria, 'se_muestra'=>1))->num_rows();
    }
    /**
     * DEVUELVE LAS CATEGORÍAS QUE SE MUESTRAN
     * @return type
     */
    public function Categorias()
    {
        $qr = $this->db->query('select * from categoria '
                . 'where se_muestra=1;');        
        return $qr->result_array();
    }
    /**
     * ACTUALIZA EL CAMPO DE STOCK TRAS HACER UNA COMPRA
     * @param type $id
     * @param type $data
     */
    public function DisminuyeStock($id, $data){
         $this->db->update('producto', $data, array('idPro' => $id));
    }
    /**
     * DEVUELVE EL NÚMERO DE PRODUCTOS QUE HAY EN LA BASE DE DATOS
     * @return type
     */
    public function num_filas_tot(){
       return $this->db->get_where('producto')->num_rows();
    }
    /**
     * DEVUELVE TODOS LOS PRODUCTOS PARA PAGINACIÓN
     * @param type $page
     * @param type $per_page
     * @return type
     */
    public function TodosProductos($page, $per_page){
        
        $qr = $this->db->query('select * from producto '
                . "where idPro>0 and stock>0 LIMIT $page, $per_page;");
        return $qr->result_array(); 
    }
    /**
     * DEVUELVE LOS PRODUCTOS DE UNA CATEGORÍA
     * @param type $categoria
     * @return type
     */
    public function ProductosDeCat($categoria)
    {
        $qr = $this->db->get_where('producto', array('Categoria_idCat'=>$categoria));
        return $qr->result_array();
    }
    /**
     * DEVUELVE EL STOCK DE UN PRODUCTO
     * @param type $id
     * @return type
     */
    public function devuelveStock($id){
        $qr = $this->db->query("select stock from producto where idPro=$id");
        return $qr->result_array(); 
    }    
    /**
     * DEVUELVE EL NÚMERO DE FILAS(1) SI EXISTE UNA CATEGORÍA
     * @param type $cat
     * @return type
     */
    public function ExisteCategoria($cat){
        return $this->db->get_where('categoria', array('idCat'=>$cat))->num_rows();
    }
    
}