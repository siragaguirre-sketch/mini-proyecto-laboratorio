<?php

use App\Models\Order;

final class OrderReportService
{
    public function generate(Order $order): string
    {
        $generator = new ReportGenerator();

        return $generator->generate("Pedido {$order->id}", true, true, false);
    }
}
