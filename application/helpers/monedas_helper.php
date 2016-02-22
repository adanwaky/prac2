<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('creaSelectMoneda')) {

    function creaSelectMoneda() {        
        $fecha = date('Y-m-d');
        $filename = '././assets/xml_monedas/' . $fecha . '-moneda.xml';
        
        if (file_exists('././assets/xml_monedas/' . $fecha . '-moneda.xml')) {
            $XML = simplexml_load_file('././assets/xml_monedas/' . $fecha . '-moneda.xml');
        } else {
            $cadena = file_get_contents("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
            file_put_contents($filename, $cadena);
            $XML = simplexml_load_file('././assets/xml_monedas/' . $fecha . '-moneda.xml');
        }
        foreach ($XML->Cube->Cube->Cube as $rate) {
            echo "<li>";
            echo "<a href=" . base_url() . 'index.php/Welcome/cambiarTarifa/' . $rate['currency'] . ">" . $rate['currency'] . "</a>";
            echo "</li>";
        }
    }

}
