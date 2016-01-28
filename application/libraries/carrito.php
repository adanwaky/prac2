<?php

class carrito {

    const CARRITO_ID = 'carrito';

    protected $carrito = array();

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            $CI = get_instance();
            $CI->load->library('session');
        }

        if (!isset($_SESSION[carrito::CARRITO_ID])) {
            $_SESSION[carrito::CARRITO_ID] = null;
            $this->carrito["precio_total"] = 0;
            $this->carrito["articulos_total"] = 0;
        }
        $this->carrito = $_SESSION[carrito::CARRITO_ID];
    }

    function introduce_pro($articulo) {
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
        $articulo["unidades"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["unidades"]));
        $articulo["precio"] = trim(preg_replace('/([^0-9\.])/i', '', $articulo["precio"]));

        $articulo["total"] = $articulo["unidades"] * $articulo["precio"];
        $this->unset_producto($unique_id);
        $_SESSION[carrito::CARRITO_ID][$unique_id] = $articulo;
        $this->update_carrito();
        $this->update_precio_cantidad();
    }

    private function update_precio_cantidad() {

        $precio = 0;
        $articulos = 0;

        foreach ($this->carrito as $row) {
            $precio += ($row['precio'] * $row['unidades']);
            $articulos += $row['unidades'];
        }

        $_SESSION[carrito::CARRITO_ID]["articulos_total"] = $articulos;
        $_SESSION[carrito::CARRITO_ID]["precio_total"] = $precio;

        $this->update_carrito();
    }

    public function precio_total() {
        if (!isset($this->carrito["precio_total"]) || $this->carrito === null) {
            return 0;
        }

        if (!is_numeric($this->carrito["precio_total"])) {
            throw new Exception("El precio total del carrito debe ser un número", 1);
        }

        return $this->carrito["precio_total"] ? $this->carrito["precio_total"] : 0;
    }

    public function articulos_total() {

        if (!isset($this->carrito["articulos_total"]) || $this->carrito === null) {
            return 0;
        }

        if (!is_numeric($this->carrito["articulos_total"])) {
            throw new Exception("El número de artículos del carrito debe ser un número", 1);
        }

        return $this->carrito["articulos_total"] ? $this->carrito["articulos_total"] : 0;
    }

    private function unset_producto($unique_id) {
        unset($_SESSION[carrito::CARRITO_ID][$unique_id]);
    }

    public function update_carrito() {
        self::__construct();
    }

    public function remove_producto($unique_id) {
        if ($this->carrito === null) {
            throw new Exception("El carrito no existe!", 1);
        }
        //si no existe la id única del producto en el carrito
        if (!isset($this->carrito[$unique_id])) {
            throw new Exception("La unique_id $unique_id no existe!", 1);
        }

        //en otro caso, eliminamos el producto, actualizamos el carrito y 
        //el precio y cantidad totales del carrito
        unset($_SESSION[carrito::CARRITO_ID][$unique_id]);
        $this->update_carrito();
        $this->update_precio_cantidad();
        return true;
    }

    //eliminamos el contenido del carrito por completo
    public function destroy() {
        unset($_SESSION[carrito::CARRITO_ID]);
        $this->carrito = null;
        return true;
    }

    public function get_content() {
        //asignamos el carrito a una variable
        $carrito = $this->carrito;
        //debemos eliminar del carrito el número de artículos
        //y el precio total para poder mostrar bien los artículos
        //ya que estos datos los devuelven los métodos 
        //articulos_total y precio_total
        unset($carrito["articulos_total"]);
        unset($carrito["precio_total"]);
        return $carrito == null ? null : $carrito;
    }

}
