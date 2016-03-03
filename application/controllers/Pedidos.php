<?php

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('usuarios');
        $this->load->model('provincias');
        $this->load->library('carrito');
        $this->load->model('productos');
        $this->load->model('pedido');
        $this->load->model('ventas');
        $this->load->helper('monedas');
    }

    /**
     * CREA EL PEDIDO, LAS VENTAS EN LA BASE DE DATOS Y ENVIA PDF AL CORREO
     * @param type $importe
     * @param type $idUs
     */
    public function Nuevopedido($importe, $idUs) {
        $user = $this->usuarios->DevuelveDatosUs($idUs); //GUARDA LOS DATOS DEL USUARIO
        $datos = ['estado' => 'Pendiente',
            'importe' => $importe,
            'user_user' => $user[0]['user'],
            'user_mail' => $user[0]['mail'],
            'user_nombreUs' => $user[0]['nombreUs'],
            'user_apellidos' => $user[0]['apellidos'],
            'user_direccion' => $user[0]['direccion'],
            'user_cp' => $user[0]['cp'],
            'user_provincia' => $user[0]['provincias_id'],
            'Usuario_idUsu' => $idUs]; //CREA EL ARRAY PARA CREAR EL PEDIDO

        $this->pedido->crearPedido($datos); //CREA EL PEDIDO EN LA BASE DE DATOS
        $carro = $this->carrito->get_content(); //COGE EL CONTENIDO DEL CARRITO
        $id_ped = $this->pedido->Ultimopedido(); //DEVUELVE LA ID DEL ÚLTIMO PEDIDO INSERTADO

        foreach ($carro as $producto) { //POR CADA PRODUCTO DEL CARRITO
            $data = array('Producto_idPro' => $producto['id'],
                'Pedido_idPed' => $id_ped[0]['id'],
                'unidades' => $producto['unidades'],
                'precio' => $producto['total'],
                'iva' => '21'); //CREA EL ARRAY
            $this->ventas->crearVenta($data); //INSERTA LA VENTA EN LA BASE DE DATOS
            $stock = $this->productos->devuelveStock($producto['id']); //DEVUELVE EL STOCK
            $nuevoStock = $stock[0]['stock'] - $producto['unidades']; //LO RESTA
            $this->productos->CambiaStock($producto['id'], array('stock' => $nuevoStock));
            //CAMBIA EL STOCK EN LA BASE DE DATOS
        }
        //ENVÍA AL CORREO EL PDF DEL PEDIDO
        $this->Enviarpdf($user, $id_ped);
    }
/**
 * ESCRIBE LA TABLA DEL PDF
 * @param type $data
 */
    public function EscribirCabecera($data) {
        $header = array('Producto', utf8_decode('Descripción'), 'Cantidad', 'Total');
        $this->pdf->FancyTable($header, $data);
    }
/**
 * GENERA EL PDF Y LO ENVÍA AL CORREO
 * @param type $user
 * @param type $id_ped
 */
    public function Enviarpdf($user, $id_ped) {
        $provincia = $this->provincias->DevuelveProvincia($user[0]['provincias_id']);//PROVINCIA DEL USUARIO
        $euros = $this->carrito->precio_total();//PRECIO TOTAL DEL CARRITO
        $this->load->library('pdf');
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->EscribirDatosPersonales(utf8_decode($user[0]['nombreUs']), utf8_decode($user[0]['apellidos']), utf8_decode($user[0]['direccion']), $user[0]['cp'], utf8_decode($provincia[0]['nombre']), $id_ped[0]['id']);
        $venta = $this->pedido->ventas($id_ped[0]['id']);
        $ventas = [];
        foreach ($venta as $ven) { //METE EN EL ARRAY LAS VENTAS CON UN FORMATO VÁLIDO PARA EL PDF
            $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
            array_push($ventas, array('descripcion' => $detalles[0]['descripcionPro'], 'nombre' => $detalles[0]['nombrePro'],
                'unidades' => $ven['unidades'], 'precio' => number_format($ven['precio'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']));
        }
        $this->EscribirCabecera($ventas); //ESCRIBE LA TABLA CON LAS VENTAS 
        $this->pdf->total(number_format($euros * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']);
        $this->pdf->AliasNbPages();
        $this->pdf->Output('F', 'assets/pedidos/pedido.pdf', true);//GUARDA EL PDF 
        //PASA LOS DATOS AL CONTROLADOR DEL CORREO PARA ENVIARLO
        redirect("/Correo/EnviarPdf/" . $user[0]['idUsu'] . "/" . $id_ped[0]['id'] . "", 'location', 301);
    }
/**
 * ESCRIBE LOS DATOS PERSONALES EN EL PDF
 * @param type $nombre
 * @param type $apellidos
 * @param type $direccion
 * @param type $cp
 * @param type $provincia
 * @param type $ped
 */
    public function EscribirDatosPersonales($nombre, $apellidos, $direccion, $cp, $provincia, $ped) {
        $this->pdf->Cell(40, 10, "Nombre: $nombre $apellidos");
        $this->pdf->Ln(5);
        $this->pdf->Cell(40, 10, utf8_decode('Dirección: ') . $direccion);
        $this->pdf->Ln(5);
        $this->pdf->Cell(40, 10, utf8_decode('Código Postal: ') . $cp);
        $this->pdf->Ln(5);
        $this->pdf->Cell(40, 10, "Provincia: $provincia");
        $this->pdf->Ln(5);
        $this->pdf->Cell(40, 10, utf8_decode('Núm. Pedido: ') . $ped);
        $this->pdf->Ln(20);
    }
/**
 * MUESTRA LOS PEDIDOS DE UN USUARIO
 * @param type $mensaje
 */
    public function MostrarPedidos($mensaje = "") {
        if($mensaje=='no'){
            $men="El pedido está siendo procesado y es imposible anularlo";
        }else{
            $men="";
        }
        $pedido = $this->pedido->pedidosDe($this->session->userdata('user'));
        $cuerpo['d1'] = $this->load->view('pedidos', array('pedido' => $pedido, 'mensaje' => $men), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }
/**
 * MUESTRA LAS VENTAS DE UN PEDIDO DE UN USUARIO
 * @param type $idPedido
 */
    public function MostrarVentas($idPedido) {
        $usuario = $this->pedido->UsuarioDePedido($idPedido); //COGE LA ID DEL USUARIO DE ESE PEDIDO
        if (@$usuario[0]['Usuario_idUsu'] != $this->session->userdata('user')) { //SI LA ID NO COINCIDE CON LA DE LA SESIÓN
           //CARGA VISTA DE ERROR 404
            $cuerpo['d1'] = $this->load->view('404', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {//SI COINCIDEN LAS ID MUESTRA LA VENTA
            $venta = $this->pedido->ventas($idPedido);
            $ventas = [];
            foreach ($venta as $ven) {
                $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
                array_push($ventas, array('img' => $detalles[0]['imagen'], 'nombre' => $detalles[0]['nombrePro'],
                    'unidades' => $ven['unidades'], 'precio' => $ven['precio']));
            }
            $cuerpo['d1'] = $this->load->view('ventas', array('ventas' => $ventas), true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        }
    }
/**
 * CAMBIA EL ESTADO DE UN PEDIDO A ANULADO
 * @param type $idPedido
 */
    public function AnularPedido($idPedido) {
        $pedido = $this->pedido->pedidonum($idPedido);
        if ($pedido[0]['estado'] == 'Procesado') { //SI ESTÁ PROCESADO NO PUEDE CAMBIARLO
            $msj = "no";
            redirect("/Pedidos/MostrarPedidos/$msj", 'location', 301);
        } else { //SI NO LO CAMBIA
            $this->subirstock($idPedido);
            $data = array('idPed' => $idPedido, 'estado' => 'Anulado');
            $this->pedido->actualizarPedido($data);
            redirect('/Pedidos/MostrarPedidos/', 'location', 301);
        }
    }
/**
 * CREA LA FACTURA EN PDF Y LA MUESTRA
 * @param type $id
 */
    public function mostrarFactura($id) {
        $usuario = $this->pedido->UsuarioDePedido($id); //GUARDA LA ID DEL USUARIO
        if (@$usuario[0]['Usuario_idUsu'] != $this->session->userdata('user')) {
            //SI LA ID DEL USUARIO NO COINCIDE CON LA DE LA SESIÓN DA ERROR 404
            $cuerpo['d1'] = $this->load->view('404', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
            $pedido = $this->pedido->pedidonum($id);
            $provincia = $this->provincias->DevuelveProvincia($pedido[0]['user_provincia']);
            $this->load->library('pdf');
            $this->pdf->AddPage();
            $this->pdf->SetFont('Arial', 'B', 13);
            $this->EscribirDatosPersonales(utf8_decode($pedido[0]['user_nombreUs']), utf8_decode($pedido[0]['user_apellidos']), utf8_decode($pedido[0]['user_direccion']), $pedido[0]['user_cp'], utf8_decode($provincia[0]['nombre']), $id);
            $venta = $this->pedido->ventas($id);
            $ventas = [];
            foreach ($venta as $ven) {
                $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
                array_push($ventas, array('descripcion' => $detalles[0]['descripcionPro'], 'nombre' => $detalles[0]['nombrePro'],
                    'unidades' => $ven['unidades'], 'precio' => number_format($ven['precio'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']));
            }
            $this->EscribirCabecera($ventas);
            $this->pdf->total(number_format($pedido[0]['importe'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']);
            $this->pdf->AliasNbPages();
            $this->pdf->Output();
        }
    }
/**
 * CREA LA FACTURA PDF Y LA DESCARGA
 * @param type $id
 */
    public function descargarFactura($id) {
        $this->load->model('pedido');
        $this->load->model('provincias');
        $this->load->model('productos');
        $pedido = $this->pedido->pedidonum($id);
        $provincia = $this->provincias->DevuelveProvincia($pedido[0]['user_provincia']);
        $this->load->library('pdf');
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->EscribirDatosPersonales(utf8_decode($pedido[0]['user_nombreUs']), utf8_decode($pedido[0]['user_apellidos']), utf8_decode($pedido[0]['user_direccion']), $pedido[0]['user_cp'], utf8_decode($provincia[0]['nombre']), $id);
        $venta = $this->pedido->ventas($id);
        $ventas = [];
        foreach ($venta as $ven) {
            $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
            array_push($ventas, array('descripcion' => $detalles[0]['descripcionPro'], 'nombre' => $detalles[0]['nombrePro'],
                'unidades' => $ven['unidades'], 'precio' => $ven['unidades'], 'precio' => number_format($ven['precio'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']));
        }
        $this->EscribirCabecera($ventas);
        $this->pdf->total(number_format($pedido[0]['importe'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']);
        $this->pdf->AliasNbPages();
        $this->pdf->Output('D', 'FACTURA.pdf', true);
    }
    /**
     * Devuelve el stock que tenía un producto cuando ha sido anulado
     * @param type $pedido
     */
    function subirstock($pedido){
        $ventas=$this->pedido->ventas($pedido);
        foreach ($ventas as $venta){
            $stock=$this->productos->devuelveStock($venta['Producto_idPro']);
            $nuevoStock=($stock[0]['stock'] + $venta['unidades']);
            echo ($nuevoStock);
           $this->productos->CambiaStock($venta['Producto_idPro'], array('stock' => $nuevoStock));
        }
    }

}
