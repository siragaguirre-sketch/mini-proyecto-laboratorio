<?php
/**
 * Reporte base que puede extenderse mediante decoradores.
 */

class ReportGenerator implements Report
{
    public function __construct(private string $contenido)
    {
    }

    public function generate(): string
    {
        return "Reporte: {$this->contenido}";
    }
}
