<?php

class Gestor_proveedor extends CI_Model {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('productos');
        $this->load->helper('url');
    }
/**
 * Devolverá la lista de productos que existen en nuestra tienda 
 * @param type $offset
 * @param type $limit
 * @return type
 */
    public function Lista($offset, $limit) {
        $listaProductosDevolver = array();
        $productos=$this->productos->TodosProductos($offset, $limit);
        foreach($productos as $producto){
            $listaProductosDevolver[$producto['idPro']] = array(
                'nombre' => $producto['nombrePro'],
                'descripcion' => $producto['descripcionPro'],
                'precio' => $producto['precio'],
                'img' => base_url().'assets/img/'.$producto['imagen'],
                'url' => site_url('detalle/index/' .$producto['idPro'])
            );
        }
        
        return $listaProductosDevolver;
    }
/**
 * Devuelve el número total de productos que hay en nuestra tienda
 * @return type
 */
    public function Total() {
        return $this->productos->num_filas_tot();
    }

}
