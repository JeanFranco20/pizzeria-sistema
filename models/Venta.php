<?php
// Modelo Venta
// Funciones relacionadas a la tabla venta (RF03 y RF04)

class Venta {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Registra una venta completa: la venta, el pedido (comanda) y el detalle de productos
    // Esto se hace en una sola transacción para que no queden datos a medias
    public function registrarVentaCompleta($usuarioId, $metodoPago, $tipoPedido, $numeroMesa, $nombreCliente, $direccion, $productosIds, $cantidades) {

        try {
            $this->conexion->beginTransaction();

            // 1. Calculamos el total y armamos la lista de productos válidos
            $total = 0;
            $detalles = [];

            foreach ($productosIds as $i => $productoId) {

                $cantidad = isset($cantidades[$i]) ? (int)$cantidades[$i] : 0;

                if ($cantidad <= 0) {
                    continue; // si no pusieron cantidad, lo saltamos
                }

                $sql = "SELECT precio FROM producto WHERE id = ? AND activo = 1";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$productoId]);
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($producto) {
                    $subtotal = $producto['precio'] * $cantidad;
                    $total += $subtotal;

                    $detalles[] = [
                        'producto_id' => $productoId,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $producto['precio']
                    ];
                }
            }

            // Si no se seleccionó ningún producto válido, cancelamos todo
            if (count($detalles) == 0) {
                $this->conexion->rollBack();
                return false;
            }

            // 2. Registramos la venta con el total calculado
            $sql = "INSERT INTO venta (usuario_id, estado, metodo_pago, total) VALUES (?, 'pagada', ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuarioId, $metodoPago, $total]);
            $ventaId = $this->conexion->lastInsertId();

            // 3. Generamos el pedido (comanda) a partir de la venta
            $sql = "INSERT INTO comanda (venta_id, tipo, estado, numero_mesa, nombre_cliente, direccion)
                    VALUES (?, ?, 'pendiente', ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                $ventaId,
                $tipoPedido,
                $numeroMesa !== '' ? $numeroMesa : null,
                $nombreCliente !== '' ? $nombreCliente : null,
                $direccion !== '' ? $direccion : null
            ]);
            $comandaId = $this->conexion->lastInsertId();

            // 4. Guardamos el detalle de productos del pedido
            $sql = "INSERT INTO detalle_comanda (comanda_id, producto_id, cantidad, precio_unitario)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);

            foreach ($detalles as $detalle) {
                $stmt->execute([
                    $comandaId,
                    $detalle['producto_id'],
                    $detalle['cantidad'],
                    $detalle['precio_unitario']
                ]);
            }

            $this->conexion->commit();
            return $ventaId;

        } catch (Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }

    // Lista las ventas hechas entre dos fechas (para los reportes)
    public function listarPorFecha($desde, $hasta) {
        $sql = "SELECT v.*, u.nombre AS cajero
                FROM venta v
                INNER JOIN usuario u ON v.usuario_id = u.id
                WHERE DATE(v.fecha) BETWEEN ? AND ?
                ORDER BY v.fecha DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Suma el total vendido entre dos fechas
    public function totalPorFecha($desde, $hasta) {
        $sql = "SELECT SUM(total) AS total
                FROM venta
                WHERE DATE(fecha) BETWEEN ? AND ? AND estado = 'pagada'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$desde, $hasta]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila['total'] ?? 0;
    }

    // Trae los 5 productos más vendidos entre dos fechas
    public function productosMasVendidos($desde, $hasta) {
        $sql = "SELECT p.nombre, SUM(dc.cantidad) AS cantidad_total
                FROM detalle_comanda dc
                INNER JOIN producto p ON dc.producto_id = p.id
                INNER JOIN comanda c ON dc.comanda_id = c.id
                INNER JOIN venta v ON c.venta_id = v.id
                WHERE DATE(v.fecha) BETWEEN ? AND ?
                GROUP BY p.id, p.nombre
                ORDER BY cantidad_total DESC
                LIMIT 5";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
