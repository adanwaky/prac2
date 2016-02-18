<?php

class ExportarXML extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('productos');
    }

    public function exportar() {
        $categorias = $this->productos->Categorias();
        $xml = new SimpleXMLElement('<categorias/>'); 

        foreach ($categorias as $categoria) {
            $xml_cat = $xml->addChild('categoria'); 
            foreach ($categoria as $key => $value) {
                $xml_cat->addChild($key, utf8_encode($value)); 
            }
            $this->XMLAddProductos($xml_cat, $categoria['idCat']); 
        }

        Header('Content-type: text/xml; charset=utf-8');
        Header('Content-type: octec/stream');
        Header('Content-disposition: filename="pro_car_mercaroche.xml"');
        print($xml->asXML());
    }

    protected function XMLAddProductos($xml_cat, $idCat) {
        $productos = $this->productos->ProductosDeCat($idCat);

        $xml_productos = $xml_cat->addChild('productos'); 

        foreach ($productos as $pro) {
            $xml_pro = $xml_productos->addChild('producto'); 

            foreach ($pro as $key => $valor) {
                $xml_pro->addChild($key, utf8_encode($valor)); 
            }
        }
    }

}
