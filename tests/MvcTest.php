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
require_once __DIR__ . '/../src/Controllers/OrderController.php';

use PHPUnit\Framework\TestCase;

final class MvcTest extends TestCase
{
    public function testControllerRendersViewForSuccessfullyCreatedOrder(): void
    {
        $output = $this->renderCreate([
            'id' => '801',
            'paciente' => 'Ana',
            'monto' => '1000',
            'tipo' => 'obra_social',
            'notificacion' => 'email',
            'destino' => 'ana@example.test',
        ]);

        $this->assertStringContainsString('<h1>Pedido creado</h1>', $output);
        $this->assertStringContainsString('Pedido 801 procesado. Total: $ 700', $output);
    }

    public function testControllerRendersValidationErrorForInvalidOrder(): void
    {
        $output = $this->renderCreate([
            'id' => '802',
            'paciente' => 'Ana',
            'monto' => '0',
            'tipo' => 'obra_social',
            'notificacion' => 'email',
            'destino' => 'ana@example.test',
        ]);

        $this->assertStringContainsString('<h1>No se pudo crear el pedido</h1>', $output);
        $this->assertStringContainsString('Monto invalido', $output);
    }

    private function renderCreate(array $query): string
    {
        $originalQuery = $_GET;
        $_GET = $query;
        ob_start();

        try {
            $controller = new OrderController($this->createOrderService());
            $controller->create();

            return (string) ob_get_contents();
        } finally {
            ob_end_clean();
            $_GET = $originalQuery;
        }
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
