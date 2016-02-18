<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Incluimos definición de clase padre
require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Tienda01 extends JSON_WebServer_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('server/gestor_tiendas_model', 'tienda');
        $this->tienda->Load('productos_tienda01');
        
        // Registramos funciones disponibles
        $this->RegisterFunction('Total()', 'Devuelve el número de elementos que tenemos en la tienda');
        $this->RegisterFunction('Lista(offset, limit)', 
                'Devuelve una lista de productos de tamaño máximo [limit] comenzando desde la posición desde [offset]');
    }

    public function Total()
    {
        return $this->tienda->Total();
    }
    
    public function Lista($offset, $limit)
    {
        return $this->tienda->Lista($offset, $limit);
    }
    
    
    /**
     * Función que se utilizará para hacer pruebas, sobre funicionamiento
     */
    public function Prueba($offset, $limit)
    {
        echo "<pre>";
        print_r($this->tienda->Lista((int)$offset,(int) $limit));
        echo "</pre>";
    }
    
    public function Producto($producto_id)
    {
        echo "<h1>Compra de producto ....</h1><p>Ha decidido comprar el producto $producto_id</p>";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */