<?php
// Modelo Comanda
// Funciones relacionadas a los pedidos que ve la cocina (RF05, RF06, RF07)

class Comanda {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Lista los pedidos junto con sus productos, ordenados por hora de registro
    public function listarPedidos() {

        $sql = "SELECT c.*, v.fecha AS fecha_venta, v.total
                FROM comanda c
                INNER JOIN venta v ON c.venta_id = v.id
                ORDER BY c.fecha ASC";

        $stmt = $this->conexion->query($sql);
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada pedido, buscamos sus productos
        foreach ($pedidos as $i => $pedido) {

            $sql2 = "SELECT dc.cantidad, p.nombre
                     FROM detalle_comanda dc
                     INNER JOIN producto p ON dc.producto_id = p.id
                     WHERE dc.comanda_id = ?";

            $stmt2 = $this->conexion->prepare($sql2);
            $stmt2->execute([$pedido['id']]);

            $pedidos[$i]['detalles'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pedidos;
    }

    // Cambia el estado de un pedido (pendiente, en_preparacion, listo, entregado)
    public function actualizarEstado($id, $nuevoEstado) {
        $sql = "UPDATE comanda SET estado = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$nuevoEstado, $id]);
    }
}
