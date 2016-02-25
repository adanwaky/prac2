<?php

//INSTALADOR DE LAS TABLAS DE LA BASE DE DATOS
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('Productos');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('monedas');
    }

    public function index() {
        $HayError = false;
        $errores = [];

        if (!$this->input->post())
            $this->load->view('setup');
        else {
            $mysqli = new mysqli($_POST['servidor'], $_POST['usuario'], 
                    $_POST['password'], $_POST['base_datos']);
            $mysqli->set_charset("utf8");
            if ($mysqli->connect_errno) {
                $HayError = true;
                $errores['base_datos'] = 'La base de datos no existe';
                $this->load->view('setup');
            } else {
                $this->LeerSql();
            }

            if (!$HayError) {//Creamos el fichero database con los datos de configuración para la bd que se han pasado
                $fichero = fopen('./config/database.php', 'w');
                if (!$fichero) {
                    echo '<h1>No se puede abrir el fichero.</h1>';
                }
                $this->crearFichero($hostname, $username, $password, $database);
                fwrite($fichero, $cadena, strlen($cadena));
                fclose($fichero);
                redirect('/Welcome/index', 'location', 301);
            }
        }
    }

    public function ErrorConf(& $errores, & $HayError) {
        if ($_POST['servidor'] == "") {
            $HayError = true;
            $errores['servidor'] = 'Campo vacío';
        }
        if ($_POST['usuario'] == "") {
            $HayError = true;
            $errores['usuario'] = 'Campo vacío';
        }
        if ($_POST['base_datos'] == "") {
            $HayError = true;
            $errores['base_datos'] = 'Campo vacío';
        }
    }

    public function LeerSql() {
        $sql = file_get_contents('././assets/importar/jardines.sql'); //Lee el sql
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
    
    public function crearFichero($hostname, $username, $password, $database){
         $cadena = "<?php \n";
         $cadena.= "defined('BASEPATH') OR exit('No direct script access allowed');\n" ;
         $cadena.='$active_group = "default";\n';
         $cadena.='$query_builder = TRUE;n';

        $cadena.='$db["default"] = array("\n';
	$cadena.="'dsn'	=> '',\n";
        $cadena.="'hostname' => '$hostname',\n";
	$cadena.="'username' => '$username',\n";
	$cadena.="'password' => '$password',\n";
	$cadena.="'database' => '$database',\n";
	$cadena.="'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
        );";

    }

}
