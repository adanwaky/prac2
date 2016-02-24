<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImportarExcel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('monedas');
        $this->load->model('xml');
    }

    public function index() {
        $cuerpo['d1'] = $this->load->view('impExcel', '', true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function ProcesaArchivo() {
        $archivo = $_FILES['archivo'];
        $objPHPExcel = PHPExcel_IOFactory::load($archivo['tmp_name']);
        //Asigno la hoja de calculo activa
        $objPHPExcel->setActiveSheetIndex(0);
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $datos = array();
        $tipo = "";
        $idCat = 0;
        for ($i = 1; $i <= $numRows; $i++) {
            $celdaB = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
            $celdaA = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
            if ($celdaB == "") {
                $tipo = $celdaA;
            } else {
                if ($celdaA == 'fec_ini' || $celdaA == 'fec_fin') {
                    $datos[$tipo][$celdaA] = PHPExcel_Style_NumberFormat::toFormattedString($celdaB, 'YYYY/MM/DD');
                } else {
                    $datos[$tipo][$celdaA] = $celdaB;
                }
            }
            if ($celdaA == "se_muestra" && $tipo == 'CATEGORIA') {
                $idCat = $this->xml->mas_categoria($datos['CATEGORIA']);
            }
            if ($celdaA == "se_muestra" && $tipo == 'PRODUCTOS') {
                $datos['PRODUCTOS']['Categoria_idCat'] = $idCat;
                $this->xml->mas_productos($datos['PRODUCTOS']);
            }
        }
       redirect('/Welcome/index', 'location', 301);
    }

}
