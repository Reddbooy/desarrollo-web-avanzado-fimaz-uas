<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");

$torneo     = $_POST['txtTorneo'];
$organizador= $_POST['txtOrganizador'];
$patrocinio = $_POST['txtPatrocinio'];
$lugar      = $_POST['txtLugar'];
$categoria  = $_POST['txtCategoria'];
$premio1    = $_POST['txtPremio1'];
$premio2    = $_POST['txtPremio2'];
$premio3    = $_POST['txtPremio3'];
$extra      = $_POST['txtExtra'];
$usuario    = $_POST['txtUsuario'];
$clave      = $_POST['txtClave'];

$ctrl = new TorneosCtrl();
$ctrl->saveTorneo($torneo, $organizador, $patrocinio, $lugar, $categoria, $premio1, $premio2, $premio3, $extra, $usuario, $clave);
?>