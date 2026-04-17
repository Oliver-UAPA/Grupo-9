# Grupo 9 – Sistema de Inventario

Sistema de gestión de inventario con PHP, MySQL y Bootstrap 5.

## Integrantes
- Plinio Sebastian Álvarez Joa – 100050156
- Oliver Abraham Leo Tolentino – 100070779
- Carlos Daniel López Arno – 100065695
- Luis Alfonso Marte Del Villar – 100041744
- Juan Emmanuel Parra Rivera – 100067697
- Javielito Ramírez Brioso – 100064766

---

## Requisitos
- PHP 8.0 o superior
- MySQL 8.0 o superior
- Servidor local: XAMPP / Laragon / WAMP

---

## Instalación

1. Clona o copia la carpeta del proyecto en `htdocs/` (XAMPP) o `www/` (Laragon).
2. Importa `grupo_9.sql` en phpMyAdmin.
3. Edita `config/db.php` si tu usuario/contraseña MySQL es diferente.
4. Abre en el navegador: `http://localhost/Grupo-9/login.php`

### Credenciales de prueba
| Usuario | Contraseña |
|---------|-----------|
| admin   | password  |

> Para cambiar la contraseña, genera un hash con `password_hash('tu_clave', PASSWORD_BCRYPT)` y actualiza la tabla `usuarios`.

---

## Estructura de archivos

```
Grupo-9/
├── config/
│   ├── db.php          ← Conexión a la BD
│   └── auth.php        ← Guard de sesión (protege páginas)
├── api/
│   └── eliminar.php    ← DELETE de productos
├── login.php           ← Login con sesiones PHP
├── logout.php          ← Cierra la sesión
├── registro_usuario.php← Registro de nuevos usuarios
├── index.php           ← Dashboard (protegido)
├── productos.php       ← Lista de productos (READ)
├── registro.php        ← Crear producto (CREATE)
├── editar.php          ← Editar producto (UPDATE)
└── grupo_9.sql         ← Base de datos
```

---

## Funcionalidades
- ✅ Login / Logout con sesiones PHP (`$_SESSION`)
- ✅ Registro de usuarios con contraseña hasheada (bcrypt)
- ✅ Protección de páginas: redirige a login si no hay sesión
- ✅ **CREATE** – Formulario para agregar productos
- ✅ **READ** – Tabla con todos los productos
- ✅ **UPDATE** – Formulario de edición
- ✅ **DELETE** – Eliminar con confirmación
- ✅ Validaciones en formularios (campos vacíos, tipos numéricos)
- ✅ Mensajes de retroalimentación (guardado, editado, eliminado)
- ✅ UI unificada con Bootstrap 5 + Bootstrap Icons
