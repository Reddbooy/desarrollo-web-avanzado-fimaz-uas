<?php
namespace Controllers;
use Models\ProductoModel;

/* La clase PublicController en PHP define un catálogo de métodos que recupera productos basados en un
search término y presenta una vista de catálogo para acceso público. */
class PublicController {
/**
 *La función "catálogo" recupera productos según un término de búsqueda y los muestra de forma pública.
 *vista de catálogo.
 */
    public function catalogo(): void {
        $termino = trim ($_GET['buscar'] ?? '');
        $productoModel = new ProductoModel;
        $productos = $productoModel->buscarPublico($termino);
        require_once __DIR__ .'/../views/public/catalogo.php';
    }
}