<?php


//Jesus Eduardo Garcia Rojas


namespace controllers;
use PDO;
use PDOException;
use models\producto;
use config\database;

class ProductoController{
    private $connection;

    public function __construct(){
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function crear(Producto $producto){

        try{

            $sql = "INSERT INTO productos (nombre, descripcion, existencia, precio)
            VALUES (:nombre, :descripcion, :existencia, :precio)";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());

            return $stmt->execute();
        
        } catch (PDOException $e){
            return false;
            //en caso de un error con un supuesto archivo log, aquí debería estar
        }
    }

    public function listar(){
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id){
        $sql = "SELECT * FROM productos WHERE id = :id;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function actualizar(Producto $producto){
        try{

            $sql = "UPDATE productos SET
            nombre = :nombre, 
            descripcion = :descripcion, 
            existencia = :existencia, 
            precio = :precio
            WHERE id = :id";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());

            return $stmt->execute();

        } catch (PDOException $e){
            return false;
            //en caso de un error con un supuesto archivo log, aquí debería estar
        }
    }

    public function eliminar($id){
        
        try{

            $sql = "DELETE FROM productos WHERE id = :id;";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();

        } catch (PDOException $e){
            return false;
            //en caso de un error con un supuesto archivo log, aquí debería estar
        }
    }

    public function buscar($termino){
        $sql = "SELECT * FROM productos 
        WHERE nombre like :termino
        OR descripcion like :termino
        ORDER BY id DESC;";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':termino', '%'.$termino.'%');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}

?>