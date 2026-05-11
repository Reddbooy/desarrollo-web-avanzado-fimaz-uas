<?php
require_once(__DIR__ . "/../../controllers/TorneosCtrl.php");

$ctrlTorneos = new TorneosCtrl();
$ctrlTorneos->delete($_GET['id']);
?>