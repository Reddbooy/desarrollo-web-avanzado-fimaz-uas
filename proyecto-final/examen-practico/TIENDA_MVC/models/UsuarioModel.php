<?php
namespace Models;

use Config\Database;
use PDO;
use PDOException;

/* Este código PHP define una clase llamada `UsuarioModel` dentro del espacio de nombres `Models`. La clase tiene un
private propiedad `` de tipo `PDO` que representa una conexión de base de datos. */
class UsuarioModel {
    private PDO $conexion;

/**
 *La función constructora inicializa una conexión de base de datos utilizando la clase Base de datos.
 */
    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

/**
 *Esta función PHP busca un usuario en una base de datos por su nombre de usuario y devuelve su información
 *si se encuentra.
 * 
 *Argumentos:
 * 
 **`username`: La función `buscarPorUsername` se utiliza para buscar un usuario en una base de datos basada en
 *su nombre de usuario. La función toma un parámetro de cadena `` que representa el nombre de usuario de
 *el usuario que desea buscar.
 * 
 *Devoluciones:
 * 
 *La función `buscarPorUsername` está devolviendo un array con la información del usuario si un usuario con el
 *el nombre de usuario especificado se encuentra en la base de datos. Si no se encuentra ningún usuario, devuelve "nulo".
 */
    public function buscarPorUsername(string $username): ?array {
        try {
            $sql = 'SELECT * FROM usuarios WHERE username = :username LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $usuario = $stmt->fetch();
            return $usuario ?: null;
        }
        catch (PDOException $e) {
            return null;
        }
    }
}