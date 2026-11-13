<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Reports/Report.php';
require_once __DIR__ . '/../src/Reports/ReportGenerator.php';
require_once __DIR__ . '/../src/Reports/DigitalSignatureDecorator.php';
require_once __DIR__ . '/../src/Reports/PdfReportDecorator.php';
require_once __DIR__ . '/../src/Reports/WatermarkDecorator.php';

use PHPUnit\Framework\TestCase;

final class DecoratorTest extends TestCase
{
    public function testDecoratorsCanBeChainedToExtendReport(): void
    {
        $report = new ReportGenerator('Pedidos del dia');
        $report = new DigitalSignatureDecorator($report);
        $report = new PdfReportDecorator($report);
        $report = new WatermarkDecorator($report);

        $this->assertSame(
            'Reporte: Pedidos del dia + firma digital + PDF + marca de agua',
            $report->generate()
        );
    }

    public function testDecoratorRejectsObjectThatDoesNotImplementReport(): void
    {
        $this->expectException(TypeError::class);

        new PdfReportDecorator(new stdClass());
    }
}
