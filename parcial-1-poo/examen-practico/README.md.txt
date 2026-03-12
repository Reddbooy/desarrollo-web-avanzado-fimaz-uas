# Examen Práctico - Parcial 1 (POO en PHP)

## Objetivo
Desarrollar un mini-sistema de usuarios aplicando los principios de Programación Orientada a Objetos en PHP, integrando clases, herencia, encapsulamiento y gestión de errores mediante excepciones.

## Tecnologías utilizadas
* **Lenguaje:** PHP 8+
* **Entorno:** Servidor local (XAMPP/Apache)
* **Paradigma:** Programación Orientada a Objetos (POO)

## Estructura del Sistema
* **Clase Usuario:** Clase base que gestiona nombre y correo. Incluye validación de formato de correo en el constructor.
* **Clase Admin:** Extiende de Usuario y añade el método para retornar el rol de "Administrador".
* **Clase Alumno:** Extiende de Usuario, añade el atributo matrícula y el método para retornar el rol de "Alumno".

## Manejo de Excepciones
Se implementó un bloque `try/catch` para capturar errores de validación en tiempo de ejecución. Si se ingresa un correo con formato inválido, el sistema lanza una excepción y muestra un mensaje controlado, evitando errores fatales.

## Instrucciones de ejecución
1. Clonar o copiar la carpeta del proyecto en el directorio `htdocs` de tu servidor local.
2. Iniciar el servidor Apache.
3. Acceder a `index.php` desde el navegador.
4. El sistema mostrará una tabla con los usuarios creados y el manejo de excepciones para los casos de prueba.

## Evidencia de Funcionamiento
* Tabla de usuarios generada correctamente.
* Mensaje controlado de excepción ante correos inválidos.