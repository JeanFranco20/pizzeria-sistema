# 🍕 Sistema Web para la Gestión de Pedidos y Ventas en una Pizzería

Proyecto desarrollado en PHP + MySQL + Bootstrap 5, usando el patrón **MVC** (Modelo - Vista - Controlador).

## 📁 Estructura del proyecto

```
pizzeria-sistema/
│
├── config/
│   └── conexion.php        -> Conexión a la base de datos (PDO)
│
├── controller/
│   ├── usuarioController.php   -> Login y registro de usuarios
│   ├── productoController.php  -> Gestión de productos (CRUD)
│   ├── ventaController.php     -> Registrar venta + generar pedido
│   ├── pedidoController.php    -> Vista cocina (cambiar estado de pedidos)
│   └── reporteController.php   -> Reportes de ventas
│
├── models/
│   ├── Usuario.php
│   ├── Producto.php
│   ├── Venta.php
│   └── Comanda.php
│
├── public/
│   ├── css/estilo.css
│   ├── js/script.js
│   └── views/              -> Todas las vistas (HTML + PHP + Bootstrap)
│
├── docs/
│   └── pizzeria_db.sql     -> Script para crear la base de datos
│
└── index.php               -> Punto de entrada (enrutador)
```

## 🧠 ¿Cómo funciona el MVC aquí?

1. **Modelo** (`models/`): son clases en PHP que se conectan a la base de
   datos y tienen las funciones para guardar, listar, editar, etc.
   No tienen HTML, solo lógica y consultas SQL.

2. **Vista** (`public/views/`): son los archivos `.php` que tienen el HTML
   con Bootstrap. Solo muestran datos, casi no tienen lógica.

3. **Controlador** (`controller/`): es el "intermediario". Recibe lo que
   el usuario envía por formularios (`$_POST`, `$_GET`), usa el modelo
   para guardar/leer datos, y luego carga la vista correspondiente.

4. **index.php**: es el que recibe todas las peticiones
   (`index.php?page=ventas`, `index.php?page=productos`, etc.) y decide
   qué controlador llamar.

## ⚙️ Instalación (con XAMPP)

1. Copia la carpeta `pizzeria-sistema` dentro de `htdocs`.
2. Abre **phpMyAdmin** y ejecuta el script `docs/pizzeria_db.sql`
   (esto crea la base de datos `pizzeria_db`, las tablas y datos de prueba).
3. Revisa `config/conexion.php` y verifica que el usuario/clave de tu
   MySQL sean correctos (por defecto `root` sin contraseña).
4. Abre en el navegador: `http://localhost/pizzeria-sistema/`

## 👤 Usuarios de prueba

| Correo               | Contraseña | Rol     |
|----------------------|------------|---------|
| admin@pizzeria.com   | admin123   | admin   |
| cajero@pizzeria.com  | cajero123  | cajero  |

## 🧩 Módulos implementados

- **Autenticación**: login y registro de usuarios.
- **Productos**: registrar, editar, activar/desactivar (RF08).
- **Ventas**: registrar venta seleccionando productos, calcula el total
  automáticamente y genera el pedido (RF03 + RF05).
- **Cocina**: visualiza los pedidos en tiempo real y permite cambiar su
  estado (pendiente → en preparación → listo → entregado) (RF06, RF07).
- **Reportes**: muestra el total vendido y los productos más vendidos
  en un rango de fechas (RF04).

## 📝 Notas

- Las contraseñas se guardan encriptadas con `password_hash()`.
- Los productos no se eliminan, solo se desactivan (campo `activo`).
- El proyecto usa Bootstrap 5 vía CDN, no necesitas instalar nada extra.
