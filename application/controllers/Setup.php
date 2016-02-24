<?php

//INSTALADOR DE LAS TABLAS DE LA BASE DE DATOS
include_once CTRL . 'Funciones.php';
$HayError = false;
$errores = [];

if (!$_POST)
    include_once VIEW . "FormSetup.php";
else {

    ErrorConf($errores, $HayError);

    if ($HayError) {
        include_once VIEW . "FormSetup.php";
    } else {
        $mysqli = new mysqli($_POST['servidor'], $_POST['usuario'], $_POST['password'], $_POST['base_datos']);
        $mysqli->set_charset("utf8");
        if ($mysqli->connect_errno) {
            $HayError = true;
            $errores['base_datos'] = 'La base de datos no existe';
            include_once VIEW . 'FormSetup.php';
        } else {
            $sql = file_get_contents('../install/jardines.sql');//Lee el sql

            if ($mysqli->multi_query($sql)) {
                do {
                    if ($resultado = $mysqli->store_result()) {
                        var_dump($resultado->fetch_all(MYSQLI_ASSOC));
                        $resultado->free();
                    }
                } while ($mysqli->more_results() && $mysqli->next_result());
            } else {
                echo "Falló la multiconsulta: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            $mysqli->close();
        }

        if (!$HayError) {//Creamos el fichero config con los datos de configuración para la bd que se han pasado
            $fichero = fopen('config.php', 'w');

            if (!$fichero) {
                echo '<h1>No se puede abrir el fichero.</h1>';
            }

            $cadena = "<?php \n";
            $cadena.= '$bd_conf' . "= array(
	            'servidor'=>'" . $_POST['servidor'] . "',
	            'usuario'=>'" . $_POST['usuario'] . "',
	            'password'=>'" . $_POST['password'] . "',
	            'base_datos'=>'" . $_POST['base_datos'] . "');";

            fwrite($fichero, $cadena, strlen($cadena));
            fclose($fichero);
            include_once CTRL . 'redireccionar.php';
        }
    }
}