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

    /**
     * CARGA LA VISTA IMPORTAR EXCEL
     */
    public function index() {
        $cuerpo['d1'] = $this->load->view('impExcel', '', true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    /**
     * PROCESA EL ARCHIVO EXCEL Y LO METE EN LA BASE DE DATOS
     */
    public function ProcesaArchivo() {
        $archivo = $_FILES['archivo']; //COGE EL ARCHIVO
        $objPHPExcel = PHPExcel_IOFactory::load($archivo['tmp_name']); //NOMBRE DEL ARCHIVO TEMPORAL EN EL SISTEMA
        $objPHPExcel->setActiveSheetIndex(0); //COGE EL PANEL 1 DEL EXEL
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); //CUENTA LAS FILAS QUE TIENE EL EXCEL
        $datos = array(); //ARRAY PARA GUARDAR LOS DATOS
        $tipo = ""; //TIPO PARA VER SI ES CATEGORÍA O PRODUCTO
        $idCat = 0; //ID DE CATEGORÍA PARA EL PRODUCTO

        for ($i = 1; $i <= $numRows; $i++) { //POR CADA FILA
            $celdaB = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue(); //CALCULO LA CELDA A$i
            $celdaA = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue(); //CALCULO LA CELDA B$i
            if ($celdaB == "") { //SI LA CELDA B ESTÁ VACÍA ES QUE ES UN TIPO
                $tipo = $celdaA; //SE LE ASIGNA EL TIPO A LA VARIABLE
            } else { //SI TIENE CONTENIDO
                if ($celdaA == 'fec_ini' || $celdaA == 'fec_fin') {
                    //SI ES UNA FECHA, LA CONVIERTO A FORMATO YYYY/MM/DD Y LO METO EN EL ARRAY
                    $datos[$tipo][$celdaA] = PHPExcel_Style_NumberFormat::toFormattedString($celdaB, 'YYYY/MM/DD');
                } else { // SI NO LO METO EN EL ARRAY SIN MÁS
                    $datos[$tipo][$celdaA] = $celdaB;
                }
            }
            if ($celdaA == "se_muestra" && $tipo == 'CATEGORIA') { 
                //SI LA ÚLTIMA CELDA ES se_muestra Y EL TIPO ES LA CATEGORÍA
                $idCat = $this->xml->mas_categoria($datos['CATEGORIA']); 
                //AÑADE LA CATEGORÍA A LA BASE DE DATOS Y DEVUELVE LA ID
            }
            if ($celdaA == "se_muestra" && $tipo == 'PRODUCTOS') {
                //SI LA ÚLTIMA CELDA ES se_muestra Y EL TIPO ES PRODUCTOS
                $datos['PRODUCTOS']['Categoria_idCat'] = $idCat;//AÑADE LA ID DE CATEGORÍA AL ARRAY
                $this->xml->mas_productos($datos['PRODUCTOS']); //METE EL PRODUCTO EN LA BASE DE DATOS
            }
        }
        redirect('/Welcome/index', 'location', 301); //MUESTRA INICIO
    }

}
