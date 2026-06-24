<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/configuracion/database.php";
require_once __DIR__ . "/clases/Productos.php";

$database = new Database();
$db = $database->getConnection();
$producto = new Productos($db);

// Metodo HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Ruta solicitada
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Quitar la base del proyecto
//$basePath = '/RESTful/api';
//$endpoint = str_replace($basePath, '', $uri);
$endpoint = trim($uri, '/');

//Separar segmentos
$segments = explode('/', $endpoint);

if ($segments[0] !== 'productos') {
    http_response_code(404);
    echo json_encode(["message" => "Recurso no encontrado"]);
    exit;
}

// GET / Productos
if ($method === 'GET' && count($segments) === 1) {
    $stmt = $producto->getProductos();
    $total = $stmt->rowCount();

    if ($total > 0) {
        $productos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = $row;
        }

        http_response_code(200);
        echo json_encode($productos);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "No se encontraron productos"]);
    }
    exit;
}
// GET /productos/1
if ($method === 'GET' && count($segments) === 2 && is_numeric($segments[1])) {
    $producto->idProducto = (int)$segments[1];

    if ($producto->getProducto()) {
        http_response_code(200);
        echo json_encode([
            "idProducto" => $producto->idProducto,
            "nombreproducto" => $producto->nombreproducto,
            "descripcion" => $producto->descripcion,
            "precioCompra" => $producto->precioVenta,
            "existencia" => $producto->existencia
        ]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Producto no encontrado"]);
    }
    exit;
}
//POST/productos
if ($method === 'POST' && count($segments) === 1) {
    $data = json_decode(file_get_contents("php://input"));

    //Validaciones
    $errores = [];

    if (empty($data->nombreproducto)) {
        $errores[] = "El nombre del producto es obligatorio";
    }

    if(!isset($data->precioCompra) || $data->precioCompra < 0) {
        $errores[] = "El precio de compra no puede ser negativo";
    }
    if (!isset($data->precioVenta) || $data->precioVenta < 0) {
        $errores[] = "El precio de venta no puede ser negativo";
    }
    if (!isset($data->existencia) || $data->existencia < 0) {
        $errores[] = "La existencia no puede ser negativa";
    }

    //Validacion PRO adicional: el precio de venta no puede ser menor al de compra
    if (isset($data->precioVenta, $data->precioCompra) && $data->precioVenta < $data->precioCompra) {
        $errores[] = "El precio de venta no puede ser menor al de compra";
    }
    //Si hay errores
    if (!empty($errores)) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "errores" => $errores
        ]);
        exit;
    }
    //Si todo OK
    $producto->nombreproducto = $data->nombreproducto;
    $producto->descripcion = $data->descripcion ?? '';
    $producto->precioCompra = $data->precioCompra;
    $producto->precioVenta = $data->precioVenta;
    $producto->existencia = $data->existencia;

    if ($producto->setProductos()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Producto creado correctamente"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Error al guardar"
        ]);
    }
    exit;
}

//PUT /productos/1
if ($method === 'PUT' && count($segments) === 2) {
    $data = json_decode(file_get_contents("php://input"));
    $producto->idProducto = (int)$segments[1];

    $errores = [];

    if (empty($data->nombreproducto)) {
        $errores[] = "Precio de compra invalido";
    }
    if ($data->precioCompra < 0) {
        $errores[] = "Precio de compra invalido";
    }
    if ($data->precioVenta < 0) {
        $errores[] = "Precio de venta invalido";
    }
    if ($data->existencia < 0) {
        $errores[] = "Existencia invalida";
    }
    if ($data->precioVenta < $data->precioCompra) {
        $errores[] = "El precio de venta no puede ser menor al de compra";
    }

    if (!empty($errores)) {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "errores" => $errores
        ]);
        exit;
    }
    $producto->nombreproducto = $data->nombreproducto;
    $producto->descripcion = $data->descripcion;
    $producto->precioCompra = $data->precioCompra;
    $producto->precioVenta = $data->precioVenta;
    $producto->existencia = $data->existencia;

    if ($producto->updateProducto()) {
        echo json_encode(["status" => "success", "message" => "Actualizado"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar"]);
    }
    exit;
}

//DELETE /productos/1
if ($method === 'DELETE' && count($segments) === 2 && is_numeric($segments[1])) {
    $producto->idProducto = (int)$segments[1];

    if ($producto->borrarProducto()) {
        http_response_code(200);
        echo json_encode(["message" => "Producto eliminado"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "No se pudo eliminar"]);
    }
    exit;
}

http_response_code(405);
echo json_encode(["message" => "Metodo no permitido o ruta invalida"]);

?>