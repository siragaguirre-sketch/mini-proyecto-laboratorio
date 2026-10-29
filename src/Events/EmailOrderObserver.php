<?php

use App\Models\Order;

final class EmailOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        (new NotificationSender())->enviar('email', 'paciente@mail.com', "Pedido {$order->id} creado");
    }
}
