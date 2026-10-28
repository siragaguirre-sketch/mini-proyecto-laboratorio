<?php

final class SmsOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        $sms = new SmsNotification();
        $sms->mandarSms(
            '3704000000',
            "Pedido {$order->id} creado"
        );
    }
}
