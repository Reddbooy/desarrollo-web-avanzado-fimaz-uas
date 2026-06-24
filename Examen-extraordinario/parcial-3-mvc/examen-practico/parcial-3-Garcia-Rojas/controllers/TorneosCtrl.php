<?php
require_once(__DIR__ . "/../models/TorneosRepositorio.php");

class TorneosCtrl {
    private $model;

    public function __construct() {
        $this->model = new TorneosRepositorio();
    }

    public function saveTorneo($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contraseña) {
        $id = $this->model->insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contraseña);
        return ($id !== false) ? header("Location: admin.php") : header("Location: torneoForm.php");
    }

    public function readTorneo() {
        return $this->model->read();
    }

    public function readOneTorneo($id) {
        return $this->model->readOne($id);
    }

    public function updateTorneo($id, $nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio) {
        return ($this->model->update($id, $nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio)) 
            ? header("Location: readOneTorneo.php?id=".$id) 
            : header("Location: torneoUpdate.php?id=".$id);
    }

    public function delete($id) {
        return ($this->model->delete($id)) 
            ? header("Location: readAllTorneos.php") 
            : header("Location: readOneTorneo.php?id=".$id);
    }
}
?>