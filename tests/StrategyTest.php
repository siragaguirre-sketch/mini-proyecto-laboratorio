<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Pricing/PricingStrategy.php';
require_once __DIR__ . '/../src/Pricing/ParticularStrategy.php';
require_once __DIR__ . '/../src/Pricing/InsuranceStrategy.php';
require_once __DIR__ . '/../src/Pricing/RetireeStrategy.php';
require_once __DIR__ . '/../src/Pricing/PriceCalculator.php';

use PHPUnit\Framework\TestCase;

final class StrategyTest extends TestCase
{
    public function testParticularStrategyCalculatesFullAmount(): void
    {
        $calculator = new PriceCalculator(new ParticularStrategy());

        $this->assertSame(1000.0, $calculator->calcular(1000.0));
    }

    public function testInsuranceStrategyAppliesDiscount(): void
    {
        $calculator = new PriceCalculator(new InsuranceStrategy());

        $this->assertSame(700.0, $calculator->calcular(1000.0));
    }

    public function testRetireeStrategyAppliesDiscount(): void
    {
        $calculator = new PriceCalculator(new RetireeStrategy());

        $this->assertSame(500.0, $calculator->calcular(1000.0));
    }

    public function testRejectsObjectThatDoesNotImplementPricingStrategy(): void
    {
        $this->expectException(TypeError::class);

        new PriceCalculator(new stdClass());
    }
}
