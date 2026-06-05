<!--Este fragmento de código PHP es un enrutador que dirige las solicitudes entrantes a diferentes controladores según
el valor del parámetro `ruta` en la URL. Aquí hay un desglose de lo que hace: --> 
<?php
require_once __DIR__.'/config/Autoload.php';

use Controllers\AuthController;
use Controllers\ProductoController;
use Controllers\PublicController;

$route = $_GET['route'] ?? 'catalogo';

$authController = new AuthController();
$productoController = new ProductoController();
$publicController = new PublicController();

switch ($route) {
    case 'login':
        $authController->showLogin();
        break;
    case 'auth/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'productos':
        $productoController->index();
        break;
    case 'productos/create':
        $productoController->create();
        break;
    case 'productos/store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->store();
        }
        break;
    case 'productos/edit':
        $productoController->edit();
        break;
    case 'productos/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->update();
        }
        break;
    case 'productos/delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoController->delete();
        }
        break;
    case 'api/productos':
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8000/productos");
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        break;
    case 'catalogo':
        default:
        $publicController->catalogo();
        break;
}
?>
