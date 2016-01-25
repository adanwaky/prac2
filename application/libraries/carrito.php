<?php

class carrito {

    const CARRITO_ID = 'carrito';

    protected $carrito = array();

    public function __construct() {

        if (!isset($_SESSION[carrito::CARRITO_ID])) {
            $CI = get_instance();
            $CI->load->library('session');
            $_SESSION[carrito::CARRITO_ID] = null;
            // $this->carrito["precio_total"] = 0;
            // $this->carrito["articulos_total"] = 0;
        }
        $this->carrito = $_SESSION[carrito::CARRITO_ID];
    }

    function introduce_pro($articulo) {//($id_pro, $nombre_pro, $precio, $img, $cantidad) {
        if (!is_array($articulo) || empty($articulo)) {
            throw new Exception("Error, el articulo no es un array!", 1);
        }

        if (!$articulo["id"] || !$articulo["unidades"] || !$articulo["precio"]) {
            throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);
        }

        if (!is_numeric($articulo["id"]) || !is_numeric($articulo["unidades"]) || !is_numeric($articulo["precio"])) {
            throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);
        }

        $unique_id = md5($articulo["id"]);

        $articulo["unique_id"] = $unique_id;

        if (!empty($this->carrito)) {
            foreach ($this->carrito as $row) {
                if ($row["unique_id"] === $unique_id) {
                    $articulo["unidades"] = $row["unidades"] + $articulo["unidades"];
                }
            }
        }

        $this->unset_producto($unique_id);
        $_SESSION[carrito::CARRITO_ID][$unique_id] = $articulo;
        $this->update_carrito();
    }

    private function unset_producto($unique_id) {
        unset($_SESSION["carrito"][$unique_id]);
    }

    public function update_carrito() {
        self::__construct();
    }

    function elimina_pro($linea) {
        $this->array_id_prod[$linea] = 0;
    }

    function resumen_carrito() {
        $carro = [];
        for ($i = 0; $i < $this->num_productos; $i++) {
            $carro[$i] = array('id_prod' => $this->array_id_prod[$i],
                'nombre_pro' => $this->array_nombre_prod[$i],
                'precio' => $this->array_precio_prod[$i],
                'imagen' => $this->array_img_prod[$i],
                'unidades' => $this->array_unidades_pro[$i]);
        }
        return $carro;
    }

    function actualizar_carrito($cantidad, $linea) {
        $this->array_unidades_prod[$linea] = $cantidad;
    }

}
