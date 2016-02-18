<?php

class Tiendas_Model extends CI_Model
{
 
    private $fileName;
        
    private $listaTiendas=array();    
    
    public function __construct() {
        parent::__construct();
        
        // Guardaremos la información en un fichero en formato JSON
        $this->fileName=__DIR__.'/registro_tiendas.json';

        $json_tiendas=  file_get_contents($this->fileName);
        $this->listaTiendas=json_decode($json_tiendas);        
    }
    
    /**
     * Guardamos la lista de tiendas
     */
    private function Save()
    {
        file_put_contents($this->fileName, json_encode($this->listaTiendas));
    }

    /**
     * Añade una nueva tienda a la lista
     * @param type $name
     * @param type $info
     * @param type $URL
     */
    public function Add($name, $info, $URL)
    {
        $this->listaTiendas[]=array(
            'id'=>sha1($name.time()),
            'name'=>$name,
            'info'=>$info,
            'URL'=>$URL,
        );
        $this->Save();
    }

    /**
     * Borra de la lista la tienda seleccionada
     * @param type $id
     */
    public function Remove($id)
    {
        $listaVieja=$this->listaTiendas;
        $this->listaTiendas=array();
        foreach($listaVieja as $idx=>$tienda)
        {
            if ($tienda->id!=$id)
            {
                //unset($this->listaTiendas[$idx]);
                //return;
                $this->listaTiendas[]=$tienda;
            }
        }
        $this->Save();        
    }

    public function Get($id)
    {
        foreach($this->listaTiendas as $tienda)
        {
            if ($tienda->id==$id)
                return $tienda;
        }
        echo "<p>ERROR: tienda no definida: $id</p>";
        echo "<pre>"; print_r($this->listaTiendas); echo "</pre>";
        return NULL;
    }  
    
    /**
     * Devuelve la lista de tiendas
     * @return type
     */
    public function & Lista()
    {
        return $this->listaTiendas;
    }
}
