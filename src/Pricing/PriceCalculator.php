<?php

class PriceCalculator
{
    public function __construct(private PricingStrategy $strategy) {}

    public function calcular(float $monto): float
    {
        return $this->strategy->calculate($monto);
    }

    public function calcularConIva(float $monto): float
    {
        return $this->calcular($monto) * 1.21;
    }
}
