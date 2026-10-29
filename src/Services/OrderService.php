<?php

use App\Models\Order;

final class OrderService
{
    /** @param Closure(string): PriceCalculator $calculatorFactory */
    public function __construct(
        private OrderValidator $validator,
        private Closure $calculatorFactory,
        private OrderRepository $repository,
        private NotificationSender $notificationSender,
        private OrderEvents $events,
        private OrderReportService $reportService
    ) {
    }

    public function procesarPedidoCompleto(
        int $id,
        string $paciente,
        float $monto,
        string $tipoPaciente,
        string $tipoNotificacion,
        string $destino
    ): string {
        $this->validator->validate($paciente, $monto);
        $total = ($this->calculatorFactory)($tipoPaciente)->calcular($monto);
        $order = new Order($id, $paciente, $total, $tipoPaciente);
        $this->repository->save($order);
        $this->notificationSender->enviar($tipoNotificacion, $destino, "Pedido {$id} por $ {$total}");
        $this->events->pedidoCreado($order);

        return $this->reportService->generate($order);
    }
}
