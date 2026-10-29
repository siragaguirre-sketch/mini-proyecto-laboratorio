<?php

use App\Models\Order;

final class SmsOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        $sms = new SmsNotification('3704000000');
        $sms->send("Pedido {$order->id} creado");
    }
}
