<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'/libraries/JSON_WebServer_Controller.php');

class Proveedor extends JSON_WebServer_Controller{

   public function __construct() {
       parent::__construct();
       $this->load->model('Gestor_proveedor', 'tienda');
        $this->RegisterFunction('Total()', 'Devuelve el número de elementos que tenemos en la tienda');
        $this->RegisterFunction('Lista(offset, limit)', 'Devuelve una lista de productos de tamaño máximo [limit] comenzando desde la posición desde [offset]');
   }
/**
 * Devolverá la lista de productos que existen en nuestra tienda 
 * @param type $offset
 * @param type $limit
 * @return type
 */
    public function Lista($offset, $limit) {
        return $this->tienda->Lista($offset, $limit);
    }
/**
 * Devuelve el número total de productos que hay en nuestra tienda
 * @return type
 */
    public function Total() {
        return $this->tienda->Total();
    }

}
