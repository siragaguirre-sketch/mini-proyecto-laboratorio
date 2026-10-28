<?php

final class InsuranceStrategy implements PricingStrategy
{
    public function calculate(float $amount): float
    {
        return $amount * 0.7;
    }
}
