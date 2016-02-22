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

    public function Nuevopedido($importe, $idUs) {
        $user = $this->usuarios->DevuelveDatosUs($idUs);
        $datos = ['estado' => 'Pendiente',
            'importe' => $importe,
            'user_user' => $user[0]['user'],
            'user_mail' => $user[0]['mail'],
            'user_nombreUs' => $user[0]['nombreUs'],
            'user_apellidos' => $user[0]['apellidos'],
            'user_direccion' => $user[0]['direccion'],
            'user_cp' => $user[0]['cp'],
            'user_provincia' => $user[0]['provincias_id'],
            'Usuario_idUsu' => $idUs];

        $this->pedido->crearPedido($datos);
        $carro = $this->carrito->get_content();
        $id_ped = $this->pedido->Ultimopedido();

        foreach ($carro as $producto) {
            $data = array('Producto_idPro' => $producto['id'],
                'Pedido_idPed' => $id_ped[0]['id'],
                'unidades' => $producto['unidades'],
                'precio' => $producto['total'],
                'iva' => '21');
            $this->ventas->crearVenta($data);
            $stock = $this->productos->devuelveStock($producto['id']);
            $nuevoStock = $stock[0]['stock'] - $producto['unidades'];
            $this->productos->DisminuyeStock($producto['id'], array('stock' => $nuevoStock));
        }

        $this->Enviarpdf($user, $id_ped);
    }

    public function EscribirCabecera($data) {
        $header = array('Producto', utf8_decode('Descripción'), 'Cantidad', 'Total');
        $this->pdf->FancyTable($header, $data);
    }

    public function Enviarpdf($user, $id_ped) {
        $provincia = $this->provincias->DevuelveProvincia($user[0]['provincias_id']);
        $euros = $this->carrito->precio_total();
        $this->load->library('pdf');
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->EscribirDatosPersonales(utf8_decode($user[0]['nombreUs']), utf8_decode($user[0]['apellidos']), utf8_decode($user[0]['direccion']), $user[0]['cp'], utf8_decode($provincia[0]['nombre']), $id_ped[0]['id']);
        $venta = $this->pedido->ventas($id_ped[0]['id']);
        $ventas = [];
        foreach ($venta as $ven) {
            $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
            array_push($ventas, array('descripcion' => $detalles[0]['descripcionPro'], 'nombre' => $detalles[0]['nombrePro'],
                'unidades' => $ven['unidades'], 'precio' => number_format($ven['precio'] * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']));
        }
        $this->EscribirCabecera($ventas);
        $this->pdf->total(number_format($euros * (float) $_SESSION['tarifa'], 2, '.', '') . ' ' . $_SESSION['moneda']);
        $this->pdf->AliasNbPages();
        $this->pdf->Output('F', 'assets/pedidos/pedido.pdf', true);
        redirect("/Correo/EnviarPdf/" . $user[0]['idUsu'] . "/" . $id_ped[0]['id'] . "", 'location', 301);
    }

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

    public function MostrarPedidos($mensaje = "") {
        $pedido = $this->pedido->pedidosDe($this->session->userdata('user'));
        $cuerpo['d1'] = $this->load->view('pedidos', array('pedido' => $pedido, 'mensaje' => $mensaje), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function MostrarVentas($idPedido) {
        $usuario = $this->pedido->UsuarioDePedido($idPedido);
        if (@$usuario[0]['Usuario_idUsu'] != $this->session->userdata('user')) {
            $cuerpo['d1'] = $this->load->view('404', '', true);
            $this->load->view('plantilla', array('cuerpo' => $cuerpo));
        } else {
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

    public function AnularPedido($idPedido) {
        $pedido = $this->pedido->pedidonum($idPedido);
        if ($pedido[0]['estado'] == 'Procesado') {
            $msj = "El_pedido_esta_procesado_y_es_imposible_anularlo";
            redirect("/Pedidos/MostrarPedidos/$msj",'location',301);
        } else {
            $data = array('idPed' => $idPedido, 'estado' => 'Anulado');
            $this->pedido->actualizarPedido($data);
           redirect('/Pedidos/MostrarPedidos/','location',301);
        }
    }

    public function mostrarFactura($id) {
        $usuario = $this->pedido->UsuarioDePedido($id);
        if (@$usuario[0]['Usuario_idUsu'] != $this->session->userdata('user')) {
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

}
