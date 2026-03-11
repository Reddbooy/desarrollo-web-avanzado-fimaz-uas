<?php
require_once "admin.php";
require_once "alumno.php";

$usuarios = [];

try {
    $admin = new Admin("Jesus Garcia", "jesus.admin@ejemplo.com");
    $usuarios[] = $admin;

    $alumno = new Alumno("Eduardo Rojas", "rojas@ejemplo.com", "J72372");
    $usuarios[] = $alumno;

    $alumnoInvalido = new Alumno("Pedro Error", "correo-invalido", "B99999");
    $usuarios[] = $alumnoInvalido;

} catch (Exception $e) {
    echo "<p>Excepción capturada: " . $e->getMessage() . "</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body>

<h2>Listado de Usuarios</h2>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Matrícula</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u->getNombre() ?></td>
            <td><?= $u->getCorreo() ?></td>
            <td><?= $u->getRol() ?></td>
            <td>
                <?= method_exists($u, "getMatricula") ? $u->getMatricula() : "-" ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>