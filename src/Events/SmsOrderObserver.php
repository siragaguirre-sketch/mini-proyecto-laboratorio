<?php

use App\Models\Order;

final class SmsOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        (new NotificationSender())->enviar('sms', '3704000000', "Pedido {$order->id} creado");
    }
}
