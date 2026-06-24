<?php
class Usuario {
    protected $nombre;
    protected $correo;
    
    public function __construct($nombre, $correo) {
        $this->nombre = $nombre;
        
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Correo invalido: $correo");
        }
        
        $this->correo = $correo;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getCorreo() {
        return $this->correo;
    }
}
?>
