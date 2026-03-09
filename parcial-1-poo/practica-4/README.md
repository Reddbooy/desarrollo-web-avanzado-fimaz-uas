# Practica 4 - Sistema POO con Excepciones

## Objetivo

Crear un sistema POO en PHP con herencia, polimorfismo, validacion de datos y manejo de excepciones.

## Requisitos

- PHP 8 
- XAMPP
- Navegador web


## Clases

**Usuario** - Clase base con validacion de correo
- Atributos: nombre, correo
- Valida correo con filter_var()
- Lanza excepcion si el correo es invalido

**Admin** - Hereda de Usuario
- Metodo getRol() retorna "Administrador"

**Alumno** - Hereda de Usuario
-  matricula
- Metodo getRol() 

**Invitado** - Hereda de Usuario
- Atributo: empresa
- Metodo getRol() 

## Ruta de ejecucion

Abre en navegador: http://localhost/


## Conceptos POO aplicados

- Encapsulamiento
- Herencia (extends)
- Polimorfismo (getRol en todas las clases)
- Validacion de datos
- Manejo de excepciones (try/catch)
