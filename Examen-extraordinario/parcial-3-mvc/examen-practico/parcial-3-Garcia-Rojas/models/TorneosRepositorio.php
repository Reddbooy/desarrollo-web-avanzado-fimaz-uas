<?php
require_once(__DIR__ . "/../config/DataBase.php");

class TorneosRepositorio {
    private $PDO;

    public function __construct() {
        $db = new DataBase();
        $this->PDO = $db->connect();
    }

    // INSERTAR
    public function insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contraseña) {
    $sql = "INSERT INTO torneos 
            (nombreTorneo, organizador, patrocinadores, sede, categoria, premio1, premio2, premio3, otroPremio, usuario, contraseña)
            VALUES 
            (:nombreTorneo, :organizador, :patrocinadores, :sede, :categoria, :premio1, :premio2, :premio3, :otroPremio, :usuario, :password)";
    
    $stmt = $this->PDO->prepare($sql);

    $stmt->bindParam(":nombreTorneo", $nombreTorneo);
    $stmt->bindParam(":organizador", $organizador);
    $stmt->bindParam(":patrocinadores", $patrocinadores);
    $stmt->bindParam(":sede", $sede);
    $stmt->bindParam(":categoria", $categoria);
    $stmt->bindParam(":premio1", $premio1);
    $stmt->bindParam(":premio2", $premio2);
    $stmt->bindParam(":premio3", $premio3);
    $stmt->bindParam(":otroPremio", $otroPremio);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":password", $contraseña);

    return ($stmt->execute()) ? $this->PDO->lastInsertId() : false;
    }

    // LISTAR TODOS
    public function read() {
        $stmt = $this->PDO->prepare("SELECT * FROM torneos");
        return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    // OBTENER UNO
    public function readOne($id) {
        $stmt = $this->PDO->prepare("SELECT * FROM torneos WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $id);
        return ($stmt->execute()) ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    // ACTUALIZAR
    public function update($id, $nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio) {
        $sql = "UPDATE torneos SET nombreTorneo=:nombreTorneo, organizador=:organizador, patrocinadores=:patrocinadores, sede=:sede, categoria=:categoria,
                premio1=:premio1, premio2=:premio2, premio3=:premio3, otroPremio=:otroPremio WHERE id=:id";
        $stmt = $this->PDO->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombreTorneo", $nombreTorneo);
        $stmt->bindParam(":organizador", $organizador);
        $stmt->bindParam(":patrocinadores", $patrocinadores);
        $stmt->bindParam(":sede", $sede);
        $stmt->bindParam(":categoria", $categoria);
        $stmt->bindParam(":premio1", $premio1);
        $stmt->bindParam(":premio2", $premio2);
        $stmt->bindParam(":premio3", $premio3);
        $stmt->bindParam(":otroPremio", $otroPremio);

        return $stmt->execute();
    }

    // ELIMINAR
    public function delete($id) {
        $stmt = $this->PDO->prepare("DELETE FROM torneos WHERE id=:id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>