
<?php

class ClienteH{
    public $idCliente  ;    
    public $nombre ;
    public $correo ;

    public function __construct($idCliente, $nombre, $correo){
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

}



?>