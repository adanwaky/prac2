<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('creaSelectMoneda')) {

    function creaSelectMoneda() {    //CREA EL SELECT PARA CAMBIO DE MONEDA
       
        $fecha = date('Y-m-d'); //GUARDO LA FECHA DE HOY
        $filename = '././assets/xml_monedas/' . $fecha . '-moneda.xml'; //NOMBRE DEL FICHERO
        
        if (file_exists('././assets/xml_monedas/' . $fecha . '-moneda.xml')) { //SI EXISTE
            //CARGA EL XML DESDE EL FICHERO 
            $XML = simplexml_load_file('././assets/xml_monedas/' . $fecha . '-moneda.xml');
        } else {//SI NO EXISTE LO CREA Y LO CARGA
            $cadena = file_get_contents("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
            file_put_contents($filename, $cadena);
            $XML = simplexml_load_file('././assets/xml_monedas/' . $fecha . '-moneda.xml');
        }
        
        $_SESSION['pag_act'] = current_url();//GUARDO LA PÁGINA ACTUAL
       
        foreach ($XML->Cube->Cube->Cube as $rate) { 
        //POR CADA MONEDA MUESTRA LA TARIFA Y HACE UN LINK PARA EL CAMBIO DE MONEDA
            echo "<li>";
            echo "<a href=" . base_url() . 'index.php/Welcome/cambiarTarifa/' . $rate['currency'] . ">" . $rate['currency'] . "</a>";
            echo "</li>";
        }
    }

}
