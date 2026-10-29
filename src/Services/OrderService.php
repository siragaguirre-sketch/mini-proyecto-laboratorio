<?php

use App\Models\Order;

class OrderService
{
    /** @param Closure(string): PriceCalculator $calculatorFactory */
    public function __construct(
        private OrderValidator $validator,
        private \Closure $calculatorFactory,
        private OrderRepository $repository,
        private NotificationSender $notificationSender
    ) {
    }

    public function createOrder(
        int $id,
        string $paciente,
        float $monto,
        string $tipoPaciente
    ): Order {
        $this->validator->validate($paciente, $monto);
        $total = ($this->calculatorFactory)($tipoPaciente)->calcular($monto);
        $order = new Order($id, $paciente, $total, $tipoPaciente);
        $this->repository->save($order);
        $this->notificationSender->enviar('email', 'paciente@mail.com', "Pedido {$id} creado");

        return $order;
    }
}
