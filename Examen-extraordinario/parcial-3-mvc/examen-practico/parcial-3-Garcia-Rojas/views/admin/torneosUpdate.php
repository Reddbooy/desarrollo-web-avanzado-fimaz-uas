<?php
require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");

$ctrl = new TorneosCtrl();

$id        = $_POST['txtId'];
$torneo    = $_POST['txtTorneo'];
$organizador = $_POST['txtOrganizador'];
$patrocinio  = $_POST['txtPatrocinio'];
$lugar       = $_POST['txtLugar'];
$categoria   = $_POST['txtCategoria'];
$premio1     = $_POST['txtPremio1'];
$premio2     = $_POST['txtPremio2'];
$premio3     = $_POST['txtPremio3'];
$extra       = $_POST['txtExtra'];

$ctrl->actualizar($id, $torneo, $organizador, $patrocinio, $lugar, $categoria, $premio1, $premio2, $premio3, $extra);
?>