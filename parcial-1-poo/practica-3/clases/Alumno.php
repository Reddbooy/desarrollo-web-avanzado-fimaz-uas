<?php
require_once 'Usuario.php';

class Alumno extends Usuario {
    private $matricula;
    
    public function __construct($nombre, $correo, $matricula) {
        parent::__construct($nombre, $correo);
        $this->matricula = $matricula;
    }
    
    public function getMatricula() {
        return $this->matricula;
    }
    
    public function getRol() {
        return "Alumno";
    }
}
?>
