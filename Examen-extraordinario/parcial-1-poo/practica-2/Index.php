<?php
require_once 'Admin.php';

// Crear administrador
$admin = new Admin("Eduardo Rojas", "eduardogarroj04@gmail.com");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 2 - Herencia</title>
</head>
<body>
    <h2>Datos del Administrador</h2>
    
    <p><b>Nombre:</b> <?php echo $admin->getNombre(); ?></p>
    <p><b>Correo:</b> <?php echo $admin->getCorreo(); ?></p>
    <p><b>Rol:</b> <?php echo $admin->getRol(); ?></p>
</body>
</html>
