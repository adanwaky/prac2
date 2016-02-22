<?php

class Gestor_proveedor extends CI_Model {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('productos');
        $this->load->helper('url');
    }

    public function Lista($offset, $limit) {
        $listaProductosDevolver = array();
        $productos=$this->productos->TodosProductos($offset, $limit);
        foreach($productos as $producto){
            $listaProductosDevolver[$producto['idPro']] = array(
                'nombre' => $producto['nombrePro'],
                'descripcion' => $producto['descripcionPro'],
                'precio' => $producto['precio'],
                'img' => 'http://localhost/prac2/assets/img/'.$producto['imagen'],
                'url' => site_url('detalle/index/' .$producto['idPro'])
            );
        }
        
        return $listaProductosDevolver;
    }

    public function Total() {
        return $this->productos->num_filas_tot();
    }

}
