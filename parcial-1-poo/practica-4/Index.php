<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica 4 - POO</title>
</head>
<body>
    <h2>Practica 4 - Sistema de Usuarios</h2>
    
    <?php
    require_once 'clases/Admin.php';
    require_once 'clases/Alumno.php';
    require_once 'clases/Invitado.php';
    
    $usuarios = [];
    
    try {
        $usuarios[] = new Admin("Eduardo Rojas", "eduardogarroj04@gmail.com");
        $usuarios[] = new Alumno("Hectorin Ayala", "Hectorin@gmail.com", "12324");
        $usuarios[] = new Invitado("MArysa quiñonez", "marysaz@gmail.com", "UAS);
        
        // Correo invalido
        $usuarios[] = new Admin("Error", "correo-malo");
        
    } catch (Exception $e) {
        echo "<p><strong>Error controlado:</strong> " . $e->getMessage() . "</p>";
    }
    ?>
    
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Matricula</th>
            <th>Empresa</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario->getNombre(); ?></td>
            <td><?php echo $usuario->getCorreo(); ?></td>
            <td><?php echo $usuario->getRol(); ?></td>
            <td><?php echo ($usuario instanceof Alumno) ? $usuario->getMatricula() : "—"; ?></td>
            <td><?php echo ($usuario instanceof Invitado) ? $usuario->getEmpresa() : "—"; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
