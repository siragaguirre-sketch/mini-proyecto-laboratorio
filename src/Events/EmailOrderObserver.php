<?php

use App\Models\Order;

final class EmailOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        $email = new EmailNotification('paciente@mail.com');
        $email->send("Pedido {$order->id} creado");
    }
}
