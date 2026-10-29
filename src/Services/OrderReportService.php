<?php

use App\Models\Order;

final class OrderReportService
{
    public function generate(Order $order): string
    {
        $report = new ReportGenerator("Pedido {$order->id}");
        $report = new DigitalSignatureDecorator($report);
        $report = new PdfReportDecorator($report);
        $report = new WatermarkDecorator($report);

        return $report->generate() . '<br>'
            . "<p>Pedido {$order->id} procesado. Total: $ {$order->amount}</p>";
    }
}
