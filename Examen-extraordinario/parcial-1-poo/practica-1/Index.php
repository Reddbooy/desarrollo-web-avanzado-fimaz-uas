<?php
require_once 'Usuario.php';

$usuario = new Usuario("Eduardo Rojas", "eduardogarroj04@gmail.com");

echo "Nombre: " . $usuario->getNombre() . "<br>";
echo "Correo: " . $usuario->getCorreo();
?>
