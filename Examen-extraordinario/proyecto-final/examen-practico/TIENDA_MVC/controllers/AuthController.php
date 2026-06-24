<?php 
namespace Controllers;

use Models\UsuarioModel;

/* La clase `AuthController` en PHP maneja la autenticación de usuarios, la gestión de sesiones y el token CSRF
valinformación y funcionalidad de inicio y cierre de sesión. */
class AuthController
{
/**
 *La función `showLogin` en PHP se utiliza para mostrar el archivo de vista de inicio de sesión.
 */
    public function showLogin(): void
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

/**
 *La función PHP `login` maneja la autenticación de inicio de sesión del usuario, la gestión de sesiones y el token CSRF.
 *validación y redirecciones basadas en el resultado del inicio de sesión.
 */
    public function login(): void   
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location : ../login');
            exit;
        }

        if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_token']) ||  !hash_equals($_SESSION['csrf_token'] , $_POST['csrf'])) {
            $_SESSION['error'] = 'No hay un token csrf.';
            header('Location : ../login');
            exit;
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario['PASSWORD'])) {
            $_SESSION['admin'] = [
                'id' => $usuario['id'],
                'username' => $usuario['username'],
                'nombre_completo' => $usuario['nombre_completo']
            ];

            $message = "El usuario ".$usuario['username']." inicio session \n";
            file_put_contents('logs.log', $message, FILE_APPEND );

            $_SESSION['success'] = 'Bienvenido, ' .$usuario['nombre_completo'] . '.';
            header('Location: ../productos');
            exit;
        }

        $_SESSION['error'] = 'Credeciales incorrectas';
        header('Location: ../login');
        exit;
    }

/**
 *La función `cerrar sesión` en PHP inicia una sesión si aún no se ha iniciado, destruye la sesión,
 *redirige a la página de inicio de sesión y sale del script.
 */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: login');
        exit;
    }
}