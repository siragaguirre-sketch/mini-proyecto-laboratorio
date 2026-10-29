<?php

use App\Models\Order;

final class OrderRepository
{
    public function save(Order $order): void
    {
        $patient = str_replace("'", "''", $order->patient);
        Connection::getInstance()->ejecutar(
            "INSERT INTO orders VALUES ({$order->id}, '{$patient}', {$order->amount})"
        );
    }
}