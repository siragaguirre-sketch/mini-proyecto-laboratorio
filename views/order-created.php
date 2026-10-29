<?php

/** @var string|null $reporte */
/** @var string|null $error */
?>
<?php if ($error !== null): ?>
    <h1>No se pudo crear el pedido</h1>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php else: ?>
    <h1>Pedido creado</h1>
    <p><?= htmlspecialchars(strip_tags($reporte), ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>