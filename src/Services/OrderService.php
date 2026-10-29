<?php
/**
 * ============================================================================
 *  SERVICIO DE PEDIDOS
 *  Patron esperado: FACADE (estructural) + separacion en servicios cohesivos
 * ============================================================================
 *
 *  ❌ DEUDA SEMBRADA
 *     Un unico metodo procesarPedidoCompleto() que hace de todo:
 *     valida, calcula, cobra, guarda, notifica, reporta y ademas imprime HTML.
 *     Es la clase que nadie quiere tocar: cualquier cambio puede romper otra cosa.
 *     Ademas repite el if por tipo de notificacion que ya existe en NotificationSender.
 *
 *  ✅ FORMA CORRECTA
 *     1. Cada paso en su propio servicio cohesivo (validacion, precio, pago...).
 *     2. Una fachada que ORQUESTA esos servicios en un metodo corto y legible.
 *     3. Las dependencias se inyectan por constructor, no se crean con new adentro.
 *
 *  ⚠️ Una fachada COORDINA. Si empieza a DECIDIR reglas de negocio, se convierte
 *     en la nueva clase que hace todo y volvimos al punto de partida.
 * ============================================================================
 */

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

