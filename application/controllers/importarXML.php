<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImportarXML extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('xml');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('monedas');
    }

    public function index() {
        $cuerpo['d1'] = $this->load->view('impXML', '', true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function ProcesaArchivo() {
        $archivo = $_FILES['archivo'];

        if (file_exists($archivo['tmp_name'])) {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml = simplexml_load_string($contentXML);
            $this->Insertar($xml);
            redirect('/Welcome/index', 'location', 301);
        } else {
           exit('Error');
        }
    }

    function Insertar($xml) {

        foreach ($xml as $categoria) {

            $cat['codCat'] = (string) $categoria->codCat;
            $cat['nombreCat'] = (string) $categoria->nombreCat;
            $cat['descripcionCat'] = (string) $categoria->descripcionCat;
            $cat['se_muestra'] = (string) $categoria->se_muestra;

            $id_cat = $this->xml->mas_categoria($cat);
            foreach ($categoria->productos->producto as $producto) {

                $pro['CodPro'] = (string) $producto->CodPro;
                $pro['nombrePro'] = (string) $producto->nombrePro;
                $pro['precio'] = (string) $producto->precio;
                $pro['imagen'] = (string) $producto->imagen;
                $pro['iva'] = (string) $producto->iva;
                $pro['descuento'] = (string) $producto->descuento;
                $pro['descripcionPro'] = (string) $producto->descripcionPro;
                $pro['destacado'] = (string) $producto->destacado;
                $pro['se_muestra'] = (string) $producto->se_muestra;
                $pro['fec_ini'] = (string) $producto->fec_ini;
                $pro['fec_fin'] = (string) $producto->fec_fin;
                $pro['stock'] = (string) $producto->stock;
                $pro['Categoria_idCat'] = $id_cat;

                $this->xml->mas_productos($pro);
            }
        }
    }

}
