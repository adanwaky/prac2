<?php

class ExportarXML extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('productos');        
        $this->load->helper('monedas');
    
    }
/**
 * EXPORTAR LAS CATEGORÍAS Y LOS PRODUCTOS A XML
 */
    public function exportar() {
        $categorias = $this->productos->Categorias(); //COGE LAS CATEGORÍAS
        $xml = new SimpleXMLElement('<categorias/>');  //CREA NUEVO XML

        foreach ($categorias as $categoria) { //POR CADA CATEGORÍA
            $xml_cat = $xml->addChild('categoria');  //COGE EL HIJO(CATEGORÍA)
            foreach ($categoria as $key => $value) { //POR CADA VALOR DE LA CATEGORÍA
                $xml_cat->addChild($key, utf8_encode($value)); //AÑADE LOS HIJOS Y EL VALOR
            }
            $this->XMLAddProductos($xml_cat, $categoria['idCat']);  //AÑADIR LOS PRODUCTOS AL XML
        }

        Header('Content-type: text/xml; charset=utf-8');
        Header('Content-type: octec/stream');
        Header('Content-disposition: filename="pro_car_mercaroche.xml"');
        print($xml->asXML()); //DESCARGA XML
    }
/**
 * AÑADE LOS PRODUCTOS AL XML
 * @param type $xml_cat
 * @param type $idCat
 */
    protected function XMLAddProductos($xml_cat, $idCat) {
        $productos = $this->productos->ProductosDeCat($idCat); //COGE LOS PRODUCTOS DE UNA CATEGORÍA
        $xml_productos = $xml_cat->addChild('productos'); //COGE LOS PRODUCTOS

        foreach ($productos as $pro) {//POR CADA PRODUCTO
            $xml_pro = $xml_productos->addChild('producto'); //COGE EL HIJO (PRODUCTO)
            foreach ($pro as $key => $valor) { //POR CADA VALOR DE UN PRODUCTO
                $xml_pro->addChild($key, utf8_encode($valor)); //AÑADE LOS HIJOS Y EL VALOR
            }
        }
    }

}
