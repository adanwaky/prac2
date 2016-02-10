<?php

class Pedidos extends CI_Controller {

    public function Nuevopedido($importe, $idUs) {
        $this->load->model('pedido');
        $this->load->helper('url');
        $this->load->model('usuarios');
        $this->load->model('ventas');
        $this->load->model('provincias');
        $this->load->library('carrito');
        $this->load->library('session');
        $this->load->model('productos');
        $user = $this->usuarios->DevuelveDatosUs($idUs);

        $datos = array('estado' => 'Pendiente',
            'importe' => $importe,
            'user_user' => $user[0]['user'],
            'user_mail' => $user[0]['mail'],
            'user_nombreUs' => $user[0]['nombreUs'],
            'user_apellidos' => $user[0]['apellidos'],
            'user_direccion' => $user[0]['direccion'],
            'user_cp' => $user[0]['cp'],
            'user_provincia' => $user[0]['provincias_id'],
            'Usuario_idUsu' => $idUs);

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
        }
        /*PARA EL PDF*/
        $provincia = $this->provincias->DevuelveProvincia($user[0]['provincias_id']);
        $euros = $this->carrito->precio_total();
        $this->load->library('pdf');
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','B',13);
        $this->EscribirDatosPersonales(utf8_decode($user[0]['nombreUs']), utf8_decode($user[0]['apellidos']),
        utf8_decode($user[0]['direccion']), $user[0]['cp'], utf8_decode($provincia[0]['nombre']), $id_ped[0]['id']);
        
        $venta = $this->pedido->ventas($id_ped[0]['id']);
        $ventas = [];
        foreach ($venta as $ven) {
            $detalles = $this->productos->DetallesDe($ven['Producto_idPro']);
            array_push($ventas, array('img' => $detalles[0]['imagen'], 'nombre' => $detalles[0]['nombrePro'],
                'unidades' => $ven['unidades'], 'precio' => $ven['precio']));
        }
        foreach ($ventas as $value){
        $this->EscribirPedidos($value);
        
        }
        $this->pdf->Output();
  
        
        //----------------
//        $this->session->unset_userdata('comprando');
//        $this->session->unset_userdata('carrito');
//        redirect('/Pedidos/MostrarPedidos', 'location', 301);
    }
    
    public function EscribirPedidos($data){
        $header = array('Producto', utf8_decode('Descripción'), 'Cantidad', 'Total');
        $this->pdf->FancyTable($header, $data);
    }
    
    public function EscribirDatosPersonales($nombre, $apellidos, $direccion, $cp, $provincia, $ped){
          
          $this->pdf->Cell(40, 10, "Nombre: $nombre $apellidos");
          $this->pdf->Ln(5);
          $this->pdf->Cell(40, 10, utf8_decode('Dirección: ').$direccion);
          $this->pdf->Ln(5);
          $this->pdf->Cell(40, 10, utf8_decode('Código Postal: ').$cp);
          $this->pdf->Ln(5);
          $this->pdf->Cell(40, 10, "Provincia: $provincia");
          $this->pdf->Ln(5);
          $this->pdf->Cell(40, 10, utf8_decode('Núm. Pedido: ').$ped);
          $this->pdf->Ln(20);
          
    }

    public function MostrarPedidos() {
        $this->load->model('pedido');
        $this->load->library('session');
        $this->load->helper('url');
        $pedido = $this->pedido->pedidosDe($_SESSION['user']);
        $cuerpo['d1'] = $this->load->view('pedidos', array('pedido' => $pedido), true);
        $this->load->view('plantilla', array('cuerpo' => $cuerpo));
    }

    public function MostrarVentas($idPedido) {
        $this->load->model('pedido');
        $this->load->model('productos');
        $this->load->library('session');
        $this->load->helper('url');
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
    
    public function AnularPedido($idPedido){
         $this->load->model('pedido');
         $this->load->helper('url');
         $data=array('idPed'=>$idPedido, 'estado'=>'Anulado');
         $this->pedido->actualizarPedido($data);
          redirect('/Pedidos/MostrarPedidos', 'location', 301);
    }

}
