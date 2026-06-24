<?php
require_once "usuario.php";

class Admin extends Usuario {

    public function getRol() {
        return "Administrador";
    }
}