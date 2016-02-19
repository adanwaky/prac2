<?php

class Gestor_proveedor extends CI_Model {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('productos');
    }

    public function Lista($offset, $limit) {
        $offset = (int) $offset;
        $limit = (int) $limit;

        $listaProductosDevolver = array();

        for ($idx = $offset; $idx < count($this->xmlProductos) && $idx - $offset < $limit; $idx++) {
            $producto = $this->xmlProductos->producto[$idx];
            $listaProductosDevolver[] = array(
                'nombre' => (string) $producto->nombre,
                'descripcion' => (string) $producto->descripcion,
                'precio' => (string) $producto->precio,
                'img' => (string) $producto->img,
                'url' => site_url('service/tienda01/producto/' . (string) $producto->id)
            );
        }
    }

    public function Load($nombreTienda) {
        // Guardaremos la información en un fichero en formato JSON
        $this->fileName = __DIR__ . '/' . $nombreTienda . '.xml';

        $this->xmlProductos = new SimpleXMLElement(file_get_contents($this->fileName));
    }

    public function Total() {
        return $this->productos->num_filas_tot();
    }

}
