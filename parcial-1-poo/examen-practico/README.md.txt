# Examen Práctico - Parcial 1 (POO en PHP)

## Objetivo
Desarrollar un sistema de gestión de usuarios aplicando los principios de la Programación Orientada a Objetos (POO) en PHP.

## Requisitos Cumplidos
* **Clase Usuario:** Base con atributos de nombre y correo; incluye validación de formato en el constructor.
* **Clase Admin:** Extiende de `Usuario` y retorna el rol de "Administrador".
* **Clase Alumno:** Extiende de `Usuario` y añade el atributo de matrícula.
* **Manejo de Errores:** Implementación de `try/catch` para capturar excepciones en correos inválidos.

## Instrucciones de Ejecución
1. Colocar los archivos en el servidor local (XAMPP).
2. Iniciar el servicio Apache.
3. Abrir `index.php` en el navegador para visualizar la tabla de usuarios y el mensaje de error controlado.

## Evidencia
* Código funcional bajo POO.
* Captura de excepciones mediante bloques `try/catch`.
* Tabla HTML generada dinámicamente con los datos de los usuarios.