# 📦 Grupo 9 – Sistema de Inventario de Productos

Sistema web de gestión de inventario desarrollado en PHP con MySQL y Bootstrap 5.  
Permite registrar, consultar, editar y eliminar productos, con autenticación por sesiones PHP.

---

## 👥 Integrantes

| Nombre | Matrícula |
|--------|-----------|
| Plinio Sebastian Álvarez Joa    | 100050156 |
| Oliver Abraham Leo Tolentino    | 100070779 |
| Carlos Daniel López Arno        | 100065695 |
| Luis Alfonso Marte Del Villar   | 100041744 |
| Juan Emmanuel Parra Rivera      | 100067697 |
| Javielito Ramírez Brioso        | 100064766 |

---

## 🛠️ Tecnologías usadas

- **PHP 8.0+** – Lógica del servidor, sesiones, CRUD
- **MySQL 8.0** – Base de datos relacional
- **PDO** – Conexión segura a la base de datos (prepared statements)
- **Bootstrap 5.3** – Framework CSS para la interfaz visual
- **Bootstrap Icons** – Íconos en la interfaz
- **XAMPP / Laragon** – Servidor local de desarrollo

---

## ✅ Funcionalidades

- 🔐 **Login seguro** con `session_start()` y `$_SESSION`
- 🔒 **Páginas protegidas**: redirigen al login si no hay sesión activa
- 🚪 **Logout**: destruye la sesión con `session_destroy()`
- 👤 **Registro de usuarios** con contraseña hasheada (bcrypt)
- ➕ **CREATE** – Registrar nuevos productos
- 📋 **READ** – Listar todos los productos en tabla
- ✏️ **UPDATE** – Editar productos existentes
- 🗑️ **DELETE** – Eliminar productos con confirmación
- ✔️ **Validaciones** en todos los formularios
- 💬 **Mensajes de retroalimentación** (guardado, editado, eliminado)

---

## 📁 Estructura del proyecto

```
Grupo-9/
├── auth.php               ← Guard de sesión (include en páginas protegidas)
├── db.php                 ← Conexión a la base de datos con PDO
├── login.php              ← Inicio de sesión
├── logout.php             ← Cierre de sesión
├── registro_usuario.php   ← Registro de nuevos usuarios
├── index.php              ← Dashboard principal (protegido)
├── productos.php          ← Lista de productos – READ (protegido)
├── registro.php           ← Crear producto – CREATE (protegido)
├── editar.php             ← Editar producto – UPDATE (protegido)
├── eliminar.php           ← Eliminar producto – DELETE (protegido)
└── grupo_9.sql            ← Script SQL para crear la base de datos
```

---

## ⚙️ Instrucciones de instalación

### 1. Requisitos previos
- XAMPP, Laragon o WAMP instalado
- PHP 8.0 o superior
- MySQL 8.0 o superior

### 2. Clonar o copiar el proyecto
Copia la carpeta `Grupo-9` dentro de:
- **XAMPP**: `C:/xampp/htdocs/Grupo-9`
- **Laragon**: `C:/laragon/www/Grupo-9`

### 3. Importar la base de datos
1. Abre **phpMyAdmin** en `http://localhost/phpmyadmin`
2. Crea una base de datos llamada `grupo_9`
3. Selecciónala y ve a la pestaña **Importar**
4. Sube el archivo `grupo_9.sql` y ejecuta

### 4. Verificar la conexión
Abre `db.php` y confirma que los datos coinciden con tu entorno:
```php
$host   = 'localhost';
$dbname = 'grupo_9';
$user   = 'root';
$pass   = '';       // en XAMPP suele estar vacío
```

### 5. Abrir en el navegador
```
http://localhost/Grupo-9/login.php
```

---

## 🔑 Credenciales de prueba

| Usuario | Contraseña |
|---------|-----------|
| `Lmarte` | (la del SQL original) |
| `admin`  | `password` |

> Para crear usuarios nuevos, usa el formulario en `registro_usuario.php`  
> o genera un hash con: `echo password_hash('tu_clave', PASSWORD_BCRYPT);`

---

## 🔄 Flujo del sistema

```
login.php
    ↓ (sesión iniciada)
index.php  ←→  productos.php  ←→  registro.php
                    ↓                  
               editar.php / eliminar.php
                    ↓
              logout.php → login.php
```

---

## 📌 Notas académicas

- El sistema usa **sesiones del servidor** (`$_SESSION`) para autenticación, no cookies manuales
- Las contraseñas se almacenan hasheadas con **bcrypt** mediante `password_hash()`
- Todas las consultas usan **prepared statements** (PDO) para evitar SQL injection
- El patrón de cada página es: PHP arriba → HTML abajo
