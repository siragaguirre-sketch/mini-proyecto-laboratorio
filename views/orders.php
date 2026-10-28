<?php

/**
 * ============================================================================
 *  VISTA: listado de pedidos (Refactorizada)
 * ============================================================================
 *
 *  ✅ REFACTORIZACIÓN APLICADA:
 *      1. Se elimina la consulta directa a la base de datos (Separación de capas / MVC).
 *      2. Se remueve el cálculo de negocio/descuentos (llega calculado desde el Controlador/Servicio).
 *      3. Se aplica htmlspecialchars() en la salida de datos para prevenir vulnerabilidades XSS.
 * ============================================================================
 */

/** @var array $pedidos Variable inyectada desde el controlador */
?>
<h1>Pedidos</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= htmlspecialchars((string) ($pedido['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) ($pedido['paciente'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) ($pedido['total'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>