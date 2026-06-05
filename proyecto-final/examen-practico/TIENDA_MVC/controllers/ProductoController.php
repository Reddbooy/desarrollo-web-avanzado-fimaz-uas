<?php

namespace Controllers;

use Models\ProductoModel;

/* La clase `ProductoController` en PHP gestiona operaciones relacionadas con el producto, incluida la creación,
editing, eliminación y validación, con funcionalidades de verificación y registro de sesiones. */
class ProductoController
{
    private ProductoModel $productoModel;
/**
 *La función PHP anterior es un constructor que inicializa una nueva instancia de la clase ProductoModel.
 */
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }
/**
 *La función `verificarSesion` comprueba si una sesión está activa y si el usuario ha iniciado sesión como usuario
 *admin, redireccionando a una página de inicio de sesión si no.
 */
    private function verificarSesion(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['admin'])) {
            header('Location: login');
            exit;
        }
    }
/**
 *La función de índice recupera y pagina datos de productos para mostrarlos en una página web.
 */
    public function index(): void
    {
        $pagina_actual = (int)($_GET['page'] ?? 1);
        $limite = 2;
        $this->verificarSesion();
        $totalProductos = $this->productoModel->obtenerTodos();
        $total_paginas = ceil(count($totalProductos) / $limite);
        $productos = $this->productoModel->paginacion($pagina_actual, $limite);
        require_once __DIR__ . '/../views/productos/index.php';
    }
/**
 *La función de creación en PHP verifica la sesión y requiere un archivo de vista específico para crear
 *productos.
 */
    public function create(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../views/productos/create.php';
    }

/**
 *La función `store` es responsable de manejar la creación de un nuevo producto, validando la entrada
 *datos, verificar el token CSRF, garantizar valores numéricos para ciertos campos, evitar negativos
 *valores, comprobar si hay SKU duplicados, cargar la imagen del producto y registrar la creación del producto
 *acción.
 */
    public function store(): void
    {
        $this->verificarSesion();
        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? ''),
            'imagen' => $_FILES['imagen'] ?? null,
        ];

        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === '' ||
            $data['imagen'] === null
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ../productos/create');
            exit;
        }

        if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_token']) ||  !hash_equals($_SESSION['csrf_token'] , $_POST['csrf'])) {
            $_SESSION['error'] = 'No hay un token csrf.';
            header('Location: ../productos/create');
            exit;
        }

        if (
            !is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])
        ) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numericos';
            header('Location: ../productos/create');
            exit;
        }
        if (
            (float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0
            || (int)$data['existencia'] < 0
        ) {
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: ../productos/create');
            exit;
        }

        if ($data['precio_venta'] < $data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta debe ser mayor o igual que el precio de compra.';
            header('Location: ../productos/create');
            exit;
        }

        if ((int)$data['existencia'] <= 0) {
            $_SESSION['error'] = 'La existencia debe ser mayor a cero.';
            header('Location: ../productos/create');
            exit;
        }

        if ($this->validarDuplicado($data['sku'])) {
            $_SESSION['error'] = 'El SKU ya está registrado.';
            header('Location: ../productos/create');
            exit;
        }

        if (!is_dir('/views/public/assets/images')) {
            mkdir('/views/public/assets/images', 0775, true);
        }

        $nombreImagen = uniqid('prod_') . '_' . basename($data['imagen']['name']);
        $destino = '/views/public/assets/images/' . $nombreImagen;

        if (move_uploaded_file($data['imagen']['tmp_name'], $destino)) {
            $data['imagen'] = $nombreImagen;
        } else {
            $_SESSION['error'] = 'Error al subir la imagen.';
            header('Location: ../productos/create');
            exit;
        }

        

        if ($this->productoModel->crear($data)) {
            $message = "El usuario ".$_SESSION['admin']['username']." agrego el producto ".$data['nombre']." \n";
            file_put_contents('logs.log', $message, FILE_APPEND );

            $_SESSION['success'] = 'Producto registrado correctamente';
        } else {
            $_SESSION['error'] = 'No fue posible registrrar el producto';
        }
        header('Location: ../productos/create');
        exit;
    }

/**
 *La función `editar` en PHP verifica la sesión, recupera un producto por ID y redirige al
 *editar la página si se encuentra el producto; de lo contrario, establece un mensaje de error y redirige a los productos
 *página.
 */
    public function edit(): void
    {
        $this->verificarSesion();
        $id = (int)($_GET['id'] ?? 0);
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: ../productos');
            exit;
        }
        require_once __DIR__ . '/../views/productos/edit.php';
    }


/**
 *La función PHP `update` se encarga de actualizar la información del producto, realizando diversas
 *validaciones, registrar la acción y redirigir al usuario en consecuencia.
 */
    public function update(): void
    {
        $this->verificarSesion();
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? ''),
        ];

        if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_token']) ||  !hash_equals($_SESSION['csrf_token'] , $_POST['csrf'])) {
            $_SESSION['error'] = 'No hay un token csrf.';
            header('Location: ../productos/edit&id=' . $id);
            exit;
        }

        if ($id <= 0) {
            $_SESSION['error'] = 'ID invalido';
            header('Location: ../productos/edit&id=' . $id);
            exit;
        }
        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ../productos/edit&id=' . $id);
            exit;
        }
        if (
            !is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
            || !is_numeric($data['existencia'])
        ) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numericos';
            header('Location: ../productos/edit&id=' . $id);
            exit;
        }
        if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0 || (int)$data['existencia'] < 0) {
            $_SESSION['error'] = 'No se permite valores negativos';
            header('Location: ../productos/edit&id=' . $id);
            exit;
        }
        if ($this->productoModel->actualizar($id, $data)) {
            $message = "El usuario ".$_SESSION['admin']['username']." actualizo el producto con id: $id \n";
            file_put_contents('logs.log', $message, FILE_APPEND );

            $_SESSION['success'] = 'Producto actualizado correctamente';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar le producto';
        }
        header('Location: ../productos');
        exit;
    }


/**
 *Esta función PHP es responsable de eliminar un producto, registrar la acción y redirigir el
 *usuario con mensajes apropiados.
 */
    public function delete(): void
    {
        $this->verificarSesion();
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'ID invalido';
            header('Location: ../productos');
            exit;
        }
        if ($this->productoModel->eliminar($id)) {
            $message = "El usuario ".$_SESSION['admin']['username']." elimino el producto con id: $id \n";
            file_put_contents('logs.log', $message, FILE_APPEND );

            $_SESSION['success'] = 'Productos eliminado correctamente';
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el producto';
        }
        header('Location: ../productos');
        exit;
    }




/**
 *La función "validarDuplicado" verifica si un producto con un determinado SKU ya existe en la base de datos.
 * 
 *Argumentos:
 *sku (cadena): SKU significa Unidad de mantenimiento de stock, que es un código único que se utiliza para identificar un
 *producto particular en la gestión de inventarios. Ayuda a rastrear y administrar productos de manera eficiente.
 * 
 *Devoluciones:
 *La función `validarDuplicado` está devolviendo un valor booleano. Devuelve "verdadero" si el SKU existe
 *en el modelo del producto (basado en el resultado del método "buscarSku") y "falso" si el SKU no lo hace
 *existir.
 */
    private function validarDuplicado(string $sku): bool
    {
        $existe = $this->productoModel->buscarSku($sku);
        return $existe !== false;
    }
}
