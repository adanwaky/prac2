<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CONTROLADOR 
 */
class XML extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mdl_xml');
    }

    public function importar() {
        $cuerpo = $this->load->view('View_importarXML', Array('' => ''), true);
        $this->load->view('View_plantilla', Array('cuerpo' => $cuerpo, 'homeactive' => 'active', 'titulo' => 'Importación en XML'));
    }

    public function ProcesaArchivo() {

        $archivo = $_FILES['archivo'];

        if (file_exists($archivo['tmp_name'])) {
            $contentXML = utf8_encode(file_get_contents($archivo['tmp_name']));
            $xml = simplexml_load_string($contentXML);

            $this->InsertFromXML($xml);

            $cuerpo = $this->load->view('View_importacionXMLCorrecta', '', true);
            $this->load->view('View_plantilla', Array('cuerpo' => $cuerpo, 'titulo' => 'Importación en XML', 'homeactive' => 'active'));
        } else {
            exit('Error abriendo el archivo XML');
        }
    }

    //Función que crea un array con los datos que lee desde el xml para insertarlos
    function InsertFromXML($xml) {

        foreach ($xml as $categoria) {

            $cat['cod_categoria'] = (string) $categoria->cod_categoria;
            $cat['nombre_cat'] = (string) $categoria->nombre_cat;
            $cat['descripcion'] = (string) $categoria->descripcion;
            $cat['mostrar'] = (string) $categoria->mostrar;

            // Inserta categoria
            $categoria_id = $this->Mdl_xml->addCategoria($cat); //Guardamos su id para poder insertar las camisetas en esa categoría

            foreach ($categoria->camisetas->camiseta as $camiseta) {

                $cam['cod_camiseta'] = (string) $camiseta->cod_camiseta;
                $cam['nombre_cam'] = (string) $camiseta->nombre_cam;
                $cam['precio'] = (string) $camiseta->precio;
                $cam['imagen'] = (string) $camiseta->imagen;
                $cam['iva'] = (string) $camiseta->iva;
                $cam['descuento'] = (string) $camiseta->descuento;
                $cam['descripcion'] = (string) $camiseta->descripcion;
                $cam['seleccionada'] = (string) $camiseta->seleccionada;
                $cam['mostrar'] = (string) $camiseta->mostrar;
                $cam['fecha_inicio'] = (string) $camiseta->fecha_inicio;
                $cam['fecha_fin'] = (string) $camiseta->fecha_fin;
                $cam['stock'] = (string) $camiseta->stock;

                $cam['idCategoria'] = $categoria_id;
                // Inserta camiseta
                $this->Mdl_xml->AddCamiseta($cam);
            }
        }
    }
}
