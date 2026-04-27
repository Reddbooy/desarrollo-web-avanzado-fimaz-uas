<!-- Jesus Eduardo Garcia Rojas-->
<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Producto.php";

class ProductoController {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function crear(Producto $producto) {
        $sql = "INSERT INTO productos (nombre, descripcion, existencia, precio) VALUES (:nombre, :descripcion, :existencia, :precio)";
        $stmt = $this->connection->prepare($sql);
        

        $stmt->bindValue(':nombre', $producto->getNombre());
        $stmt->bindValue(':descripcion', $producto->getDescripcion());
        $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
        $stmt->bindValue(':precio', $producto->getPrecio());

        return $stmt->execute();
    }


    public function listar() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function actualizar(Producto $producto) {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, existencia = :existencia, precio = :precio WHERE id = :id";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':nombre', $producto->getNombre());
        $stmt->bindValue(':descripcion', $producto->getDescripcion());
        $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
        $stmt->bindValue(':precio', $producto->getPrecio());
        $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    
    public function buscar($termino){
        $sql = "SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':termino', '%' . $termino . '%');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
?>