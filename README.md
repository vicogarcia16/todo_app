# To-Do App

## Descripción

Esta es una aplicación de lista de tareas simple desarrollada en PHP con una base de datos PostgreSQL para gestionar tareas. Los usuarios pueden registrarse, iniciar sesión, agregar tareas, marcar como completadas y eliminarlas.

## Tecnologías

- **PHP**: Lenguaje principal para el backend.
- **PostgreSQL**: Base de datos para almacenar los usuarios y las tareas.
- **PDO**: Para interactuar con la base de datos de manera segura.
- **HTML/CSS/Bootstrap**: Frontend para la interfaz de usuario.

## Características

- Registro de usuarios.
- Inicio de sesión de usuarios.
- Agregar, eliminar y marcar tareas como completadas.
- Listado de tareas ordenado por fecha de creación.

## Instalación

### Requisitos

- **PHP 7.4 o superior**
- **Composer**
- **Base de datos PostgreSQL**
- **Servidor web (Apache o Nginx)**

### 1. Clonar el repositorio

Primero, clona el repositorio a tu máquina local:

```bash
git clone https://github.com/vicogarcia16/todo_app.git
cd todo_app
```
### 2. Instalar dependencias

Ejecuta el siguiente comando para instalar las dependencias usando Composer:
```bash
composer install
```

### 3. Configurar las variables de entorno
Crea un archivo .env en la raíz del proyecto y agrega tus credenciales de la base de datos:
```bash
DB_HOST=localhost
DB_NAME=todo_app
DB_USER=usuario
DB_PASS=contraseña
```
### 4. Crear la base de datos
Asegúrate de tener la base de datos configurada. Puedes crear las tablas con el siguiente comando SQL:
```sql
CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```
### 5. Ejecutar el servidor
```bash
php -S localhost:8000
```
Esto iniciará la aplicación en http://localhost:8000.

