<?php

class carrito {

    var $num_productos;
    var $array_id_prod;
    var $array_nombre_prod;
    var $array_precio_prod;
    var $array_img_prod;
    var $array_unidades_pro;

    public function __construct() {
        $this->num_productos = 0;
    }

    function introduce_pro($id_pro, $nombre_pro, $precio, $img, $cantidad) {
        $this->array_id_prod[$this->num_productos] = $id_pro;
        $this->array_nombre_prod[$this->num_productos] = $nombre_pro;
        $this->array_precio_prod[$this->num_productos] = $precio;
        $this->array_img_prod[$this->num_productos] = $img;
        $this->array_unidades_pro[$this->num_productos] = $cantidad;
        $this->num_productos++;
    }

    function elimina_pro($linea) {
        $this->array_id_prod[$linea] = 0;
    }
    
    function resumen_carrito()
    {       
       return array('id_prod'=>  $this->array_id_prod, 
            'nombre_pro'=>  $this->array_nombre_prod, 
            'precio'=>  $this->array_precio_prod,
            'imagen'=>  $this->array_img_prod,
            'unidades'=>  $this->array_unidades_pro);
    }
    
    function actualizar_carrito($cantidad, $linea)
    {
        $this->array_unidades_prod[$linea] = $cantidad;
    }

}
