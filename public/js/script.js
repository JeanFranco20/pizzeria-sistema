// script.js - Rapi Pizza

// Esto se ejecuta cuando termina de cargar la página
document.addEventListener("DOMContentLoaded", function () {

    // ---------------------------------------------------
    // 1. Calcular el total de la venta cuando cambian las cantidades
    // ---------------------------------------------------
    const inputsCantidad = document.querySelectorAll(".input-cantidad");
    const totalSpan = document.getElementById("totalVenta");

    function calcularTotal() {
        let total = 0;

        inputsCantidad.forEach(function (input) {
            const fila = input.closest("tr");
            const precioCelda = fila.querySelector(".precio-producto");
            const precio = parseFloat(precioCelda.getAttribute("data-precio"));
            const cantidad = parseInt(input.value) || 0;

            total += precio * cantidad;
        });

        if (totalSpan) {
            totalSpan.textContent = total.toFixed(2);
        }
    }

    inputsCantidad.forEach(function (input) {
        input.addEventListener("input", calcularTotal);
    });

    // Calculamos una vez al cargar, por si quedaron cantidades guardadas
    calcularTotal();


    // ---------------------------------------------------
    // 2. Mostrar/ocultar campos según el tipo de pedido (local, llevar, delivery)
    // ---------------------------------------------------
    const tipoPedido = document.getElementById("tipo_pedido");
    const campoMesa = document.getElementById("campo_mesa");
    const campoCliente = document.getElementById("campo_cliente");
    const campoDireccion = document.getElementById("campo_direccion");

    function actualizarCamposPedido() {

        if (!tipoPedido) {
            return;
        }

        const valor = tipoPedido.value;

        // Por defecto ocultamos todo
        campoMesa.classList.add("d-none");
        campoCliente.classList.add("d-none");
        campoDireccion.classList.add("d-none");

        if (valor === "local") {
            campoMesa.classList.remove("d-none");
        }

        if (valor === "llevar") {
            campoCliente.classList.remove("d-none");
        }

        if (valor === "delivery") {
            campoCliente.classList.remove("d-none");
            campoDireccion.classList.remove("d-none");
        }
    }

    if (tipoPedido) {
        tipoPedido.addEventListener("change", actualizarCamposPedido);
        actualizarCamposPedido(); // ejecutamos una vez al cargar
    }

});
