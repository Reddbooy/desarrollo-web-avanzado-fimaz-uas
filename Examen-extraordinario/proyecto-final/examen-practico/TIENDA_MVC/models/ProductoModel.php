<?php

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/* La clase `ProductoModel` en PHP contiene métodos para interactuar con una tabla de base de datos llamada
"productos", incluida la recuperación, búsqueda, creación, actualización y eliminación de registros de productos, así como
well como manejo de paginación y búsquedas basadas en SKU. */
class ProductoModel
{
    private PDO $conexion;

/**
 *La función PHP anterior es un constructor que crea un nuevo objeto de base de datos y establece una
 *conexión a la base de datos.
 */
    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

/**
 *La función "obtenerTodos" recupera todos los registros de la tabla "productos" en orden descendente de
 *ID usando una consulta PDO en PHP.
 * 
 *Devoluciones:
 * 
 *Un array de todas las filas de la tabla "productos", ordenadas por la columna "id" en orden descendente
 *está siendo devuelto. Si hay un error durante la ejecución de la consulta de la base de datos, se muestra una matriz vacía.
 *regresó.
 */
    public function obtenerTodos(): array
    {
        try {
            $sql = 'SELECT * FROM productos ORDER BY id DESC';
            $stmt = $this->conexion->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

/**
 *La función "buscarPublico" busca productos en una base de datos en base a un término de búsqueda determinado y
 *devuelve los resultados.
 * 
 *Argumentos:
 * 
 **`termino`: La función `buscarPublico` es un método que busca productos en una base de datos basada
 *en un término de búsqueda determinado. Aquí hay un desglose de la función y sus parámetros:
 * 
 *Devoluciones:
 * 
 *Una serie de resultados de búsqueda de la tabla "productos" según el término de búsqueda proporcionado. si el
 *el término de búsqueda está vacío, devolverá todos los registros de la tabla. Si hay un error durante el
 *ejecución de la consulta de la base de datos, se devolverá una matriz vacía.
 */
    public function buscarPublico(string $termino = ''): array
    {
        try {
            if (trim($termino) === '') {
                return $this->obtenerTodos();
            }

            $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC';
            $stmt = $this->conexion->prepare($sql);
            $busqueda = '%' . $termino . '%';
            $stmt->bindParam(':termino', $busqueda);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

/**
 *La función "obtenerPorId" recupera un producto por su ID de una tabla de base de datos y lo devuelve como un
 *matriz o nulo si no se encuentra.
 * 
 *Argumentos:
 * 
 **`id`: La función `obtenerPorId` es un método PHP que recupera un producto de una tabla de base de datos
 *llamado `productos` basado en el `id` proporcionado. La función toma un parámetro entero ``
 *representa el identificador único del producto que se va a recuperar.
 * 
 *Devoluciones:
 * 
 *La función `obtenerPorId` está devolviendo un array con los datos del producto que coincide con el
 *ID proporcionado, o "nulo" si no se encuentra ningún producto o se produce una excepción durante la consulta de la base de datos.
 */
    public function obtenerPorId(int $id): ?array
    {
        try {
            $sql = 'SELECT * FROM productos WHERE id = :id LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $producto = $stmt->fetch();
            return $producto ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

/**
 *La función `crear` inserta datos del producto en una tabla de base de datos con manejo de errores y transacciones
 *manejo en PHP.
 * 
 *Argumentos:
 * 
 **`data`: La función `crear` que proporcionaste es responsable de insertar un nuevo producto en un
 *tabla de base de datos denominada `productos`. Toma una matriz `` como parámetro, que debe contener el
 *siguientes claves:
 * 
 *Devoluciones:
 * 
 *Esta función devuelve un valor booleano. Si la inserción del producto en la base de datos es
 *exitoso, devolverá "verdadero". Si hay un error durante el proceso o se produce una excepción
 *atrapado, devolverá "falso".
 */
    public function crear(array $data): bool
    {
        try {
            $this->conexion->beginTransaction();
            $sql = 'INSERT INTO productos (sku, nombre, descripcion, precio_compra, precio_venta, existencia, imagen)
            VALUES (:sku, :nombre, :descripcion, :precio_compra, :precio_venta, :existencia, :imagen)';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);

            $resultado = $stmt->execute();
            if (!$resultado) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

/**
 *La función `actualizar` actualiza un registro en la tabla `productos` con los datos proporcionados mediante un
 *transacción en PHP.
 * 
 *Argumentos:
 * 
 **`id`: El parámetro `id` en la función `actualizar` es un número entero que representa el único
 *identificador del producto que desea actualizar en la base de datos.
 **`data`: El parámetro `data` en la función `actualizar` es un array que contiene los valores a
 *ser actualizado en la tabla `productos`. Las claves de la matriz corresponden a los nombres de las columnas del
 *tabla, y los valores son los nuevos valores que se establecerán para esas columnas.
 * 
 *Devoluciones:
 * 
 *La función `actualizar` devuelve un valor booleano. Si la operación de actualización es exitosa, devuelve
 *`verdadero`. Si hay una excepción (como una `PDOException`) durante el proceso de actualización, detecta
 *la excepción, revierte la transacción si estaba en progreso y devuelve "falso".
 */
    public function actualizar(int $id, array $data): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sql = 'UPDATE productos SET
        sku = :sku,
        nombre = :nombre,
        descripcion = :descripcion,
        precio_compra = :precio_compra,
        precio_venta = :precio_venta,
        existencia = :existencia
        WHERE id = :id';   // ← sin coma antes del WHERE

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ← faltaba este

            $stmt->execute();
            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

/**
 *Esta función PHP se utiliza para eliminar un registro de una tabla de base de datos usando una ID específica, con
 *Manejo de transacciones para garantizar la integridad de los datos.
 * 
 *Argumentos:
 * 
 **`id`: La función `eliminar` es un método que toma un parámetro entero `` que representa el
 *ID del producto a eliminar de la tabla de la base de datos denominada `productos`.
 * 
 *Devoluciones:
 * 
 *Esta función devuelve un valor booleano. Si la eliminación del producto con el ID especificado es
 *exitoso, devuelve verdadero. Si la eliminación falla (por ejemplo, si ninguna fila se vio afectada por la
 *operación de eliminación), devuelve falso. Si se detecta una excepción (PDOException) durante el proceso,
 *también devuelve falso después de revertir cualquier cambio realizado dentro de la transacción.
 */
    public function eliminar(int $id): bool
    {
        try {
            $this->conexion->beginTransaction();
            $sql = 'DELETE FROM productos WHERE id = :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

/**
 *La función `buscarSku` busca un producto por SKU en una base de datos y devuelve verdadero si el producto
 *existe, falso en caso contrario.
 * 
 *Argumentos:
 * 
 **`sku`: La función `buscarSku` está diseñada para buscar un producto en una tabla de base de datos llamada
 *`productos` basado en el SKU (Stock Keeping Unit) proporcionado como input. La función utiliza una consulta SQL.
 *para seleccionar registros de la tabla `productos` donde la columna SKU coincide con el SKU de entrada usando un
 * 
 *Devoluciones:
 * 
 *La función `buscarSku` devuelve un valor booleano. Devuelve "verdadero" si hay al menos uno.
 *producto en la base de datos con un SKU que coincide con el SKU proporcionado, y "falso" si no hay
 *coincide o si se produce una excepción (PDOException) durante la consulta de la base de datos.
 */
    public function buscarSku(string $sku): bool{
        try {
            $sql = 'SELECT * FROM productos WHERE sku LIKE :sku LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $sku, PDO::PARAM_STR);
            $stmt->execute();
            $existe = $stmt->fetchAll();
            return count($existe) > 0 ? true : false;
        } catch (PDOException $e) {
            return false;
        }
    }

/**
 *Esta función PHP realiza la paginación en una consulta de base de datos para recuperar un número específico de registros
 *basado en el número de página y el límite proporcionado.
 * 
 *Argumentos:
 * 
 **`pagina`: El parámetro `` en la función `paginacion` representa el número de página que deseas
 *para recuperar datos en una lista paginada de productos. Es un valor entero que indica la
 *página específica de resultados que le interesa ver.
 **`limite`: El parámetro `` en la función `paginacion` representa el número de elementos a
 *visualización por página en una lista paginada. Se utiliza para limitar el número de resultados recuperados del
 *consulta de base de datos.
 * 
 *Devoluciones:
 * 
 *Se devuelve una serie de productos después de ejecutar la consulta SQL para recuperar productos del
 *tabla de base de datos "productos" con paginación basada en el número y límite de página proporcionados. si un
 *se produce una excepción (PDOException) durante la ejecución, se devuelve una matriz vacía.
 */
    public function paginacion(int $pagina, int $limite): array
    {
        try {
            $offset = ($pagina - 1) * $limite;
            $sql = 'SELECT * FROM productos ORDER BY id DESC LIMIT :limite OFFSET :offset';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }

    }
}
