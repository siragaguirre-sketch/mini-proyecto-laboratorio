<?php

final class EmailOrderObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        $email = new EmailNotification();
        $email->enviarEmail(
            'paciente@mail.com',
            'Pedido creado',
            "Pedido {$order->id}"
        );
    }
}
