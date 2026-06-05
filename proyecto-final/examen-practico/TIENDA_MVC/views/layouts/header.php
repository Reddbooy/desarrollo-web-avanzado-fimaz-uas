<!--Este fragmento de código PHP es una plantilla HTML básica con algo de PHP integrado. Aquí hay un desglose
de lo que hace cada parte: --> 
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Desarrollo Web Avanzado: POO+PDO+TryCatch-Namespaces-Autoload-Transacciones-MVC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="./catalogo">Tienda MVC</a>
            <div>
                <a class="btn btn-outline-light btn-sm me-2" href="./catalogo">Catalogo</a>
                <a class="btn btn-warning btn-sm" href="./login">Administrador</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4 flex-grow-1">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>