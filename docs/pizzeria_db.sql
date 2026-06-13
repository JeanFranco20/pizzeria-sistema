-- ==========================================================
-- BASE DE DATOS: pizzeria_db
-- Sistema Web para la Gestión de Pedidos y Ventas en una Pizzería
-- ==========================================================

CREATE DATABASE IF NOT EXISTS pizzeria_db;
USE pizzeria_db;

-- ----------------------------------------------------------
-- Tabla USUARIO
-- ----------------------------------------------------------
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'cajero',
    activo INT NOT NULL DEFAULT 1
);

-- ----------------------------------------------------------
-- Tabla PRODUCTO
-- ----------------------------------------------------------
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    categoria VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    activo INT NOT NULL DEFAULT 1
);

-- ----------------------------------------------------------
-- Tabla VENTA
-- ----------------------------------------------------------
CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'abierta',
    metodo_pago VARCHAR(50),
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    motivo_anulacion VARCHAR(255),
    anulada_por INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT venta_usuario_fk FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    CONSTRAINT venta_anulado_fk FOREIGN KEY (anulada_por) REFERENCES usuario(id)
);

-- ----------------------------------------------------------
-- Tabla COMANDA (pedido)
-- ----------------------------------------------------------
CREATE TABLE comanda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    tipo VARCHAR(20) NOT NULL,           -- local, llevar, delivery
    estado VARCHAR(20) NOT NULL DEFAULT 'pendiente', -- pendiente, en_preparacion, listo, entregado
    numero_mesa INT,
    nombre_cliente VARCHAR(100),
    direccion VARCHAR(255),
    observacion VARCHAR(255),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT comanda_venta_fk FOREIGN KEY (venta_id) REFERENCES venta(id)
);

-- ----------------------------------------------------------
-- Tabla DETALLE_COMANDA
-- ----------------------------------------------------------
CREATE TABLE detalle_comanda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comanda_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT detalle_comanda_fk FOREIGN KEY (comanda_id) REFERENCES comanda(id),
    CONSTRAINT detalle_producto_fk FOREIGN KEY (producto_id) REFERENCES producto(id)
);


-- ==========================================================
-- DATOS DE PRUEBA
-- ==========================================================

-- Usuarios (la contraseña ya está encriptada con password_hash de PHP)
-- admin@pizzeria.com -> clave: admin123
-- cajero@pizzeria.com -> clave: cajero123
INSERT INTO usuario (nombre, correo, password, rol) VALUES
('Administrador', 'admin@pizzeria.com', '$2b$12$njuJVFXS1TdWA9XnOe9ON.EqTzXiZQMTMKtZ546YQQwq./d27GqH6', 'admin'),
('Cajero', 'cajero@pizzeria.com', '$2b$12$9WhnpsTmVUolHN2sLAQfeO1ln8ETlpYoqC.B/jg50EU4u6cEQAK3e', 'cajero');

-- Productos
INSERT INTO producto (nombre, descripcion, categoria, precio) VALUES
('Pizza Margarita', 'Salsa de tomate, mozzarella y albahaca', 'Pizza', 25.00),
('Pizza Pepperoni', 'Salsa de tomate, mozzarella y pepperoni', 'Pizza', 30.00),
('Pizza Hawaiana', 'Jamón, piña y mozzarella', 'Pizza', 28.00),
('Gaseosa 500ml', 'Bebida gaseosa personal', 'Bebida', 5.00),
('Inca Kola 1.5L', 'Bebida gaseosa familiar', 'Bebida', 8.00),
('Alitas BBQ (6 unid)', 'Alitas de pollo bañadas en salsa BBQ', 'Entrada', 18.00);
