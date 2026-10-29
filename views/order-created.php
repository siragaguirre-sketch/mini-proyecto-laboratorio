<?php

use App\Models\Order;

/** @var Order|null $pedido */
/** @var string|null $error */
?>
<?php if ($error !== null): ?>
    <h1>No se pudo crear el pedido</h1>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php else: ?>
    <h1>Pedido creado</h1>
    <p>Paciente: <?= htmlspecialchars($pedido->patient, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Total: $ <?= htmlspecialchars((string) $pedido->amount, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>