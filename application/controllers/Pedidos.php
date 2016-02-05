<?php

class Pedidos extends CI_Controller {

    public function Nuevopedido($importe, $idUs) {
        $this->load->model('pedido');
        $this->load->helper('url');
        $this->load->model('usuarios');
        $this->load->model('ventas');
        $this->load->library('carrito');
        $this->load->library('session');
        $user=  $this->usuarios->DevuelveDatosUs($idUs);
        
        $datos = array('estado'=>'pendiente',
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
       $id_ped=  $this->pedido->Ultimopedido();
       
        foreach($carro as $producto){
            $data=array('Producto_idPro'=>$producto['id'],
                'Pedido_idPed'=>$id_ped[0]['id'],
                'unidades'=>$producto['unidades'],
                'precio'=>$producto['total'],
                'iva'=>'21');
            $this->ventas->crearVenta($data);
        }
        $this->session->unset_userdata('comprando');
        $this->session->unset_userdata('carrito');
        //ir a pedidos
        
    }

}
