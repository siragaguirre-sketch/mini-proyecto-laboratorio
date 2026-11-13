<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Database/Connection.php';
require_once __DIR__ . '/../src/Notifications/Notification.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifier.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifierAdapter.php';
require_once __DIR__ . '/../src/Notifications/NotificationSender.php';
require_once __DIR__ . '/../src/Pricing/PricingStrategy.php';
require_once __DIR__ . '/../src/Pricing/InsuranceStrategy.php';
require_once __DIR__ . '/../src/Pricing/PriceCalculator.php';
require_once __DIR__ . '/../src/Events/OrderObserver.php';
require_once __DIR__ . '/../src/Events/OrderEvents.php';
require_once __DIR__ . '/../src/Services/OrderValidator.php';
require_once __DIR__ . '/../src/Services/OrderRepository.php';
require_once __DIR__ . '/../src/Reports/Report.php';
require_once __DIR__ . '/../src/Reports/ReportGenerator.php';
require_once __DIR__ . '/../src/Reports/DigitalSignatureDecorator.php';
require_once __DIR__ . '/../src/Reports/PdfReportDecorator.php';
require_once __DIR__ . '/../src/Reports/WatermarkDecorator.php';
require_once __DIR__ . '/../src/Services/OrderReportService.php';
require_once __DIR__ . '/../src/Services/OrderService.php';

use PHPUnit\Framework\TestCase;

final class FacadeTest extends TestCase
{
    public function testFacadeProcessesValidOrderAndReturnsReport(): void
    {
        $service = $this->createOrderService();

        ob_start();
        $report = $service->procesarPedidoCompleto(
            701,
            'Ana',
            1000.0,
            'obra_social',
            'email',
            'ana@example.test'
        );
        ob_end_clean();

        $this->assertSame(
            'Reporte: Pedido 701 + firma digital + PDF + marca de agua<br>'
            . '<p>Pedido 701 procesado. Total: $ 700</p>',
            $report
        );
    }

    public function testFacadeRejectsInvalidOrderBeforeProcessingIt(): void
    {
        $service = $this->createOrderService();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Falta el paciente');

        $service->procesarPedidoCompleto(
            702,
            ' ',
            1000.0,
            'obra_social',
            'email',
            'ana@example.test'
        );
    }

    private function createOrderService(): OrderService
    {
        return new OrderService(
            new OrderValidator(),
            static fn (string $type): PriceCalculator => new PriceCalculator(new InsuranceStrategy()),
            new OrderRepository(),
            new NotificationSender(),
            new OrderEvents(),
            new OrderReportService()
        );
    }
}
