<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

final class Estimate
{
    private float $factor = 1.0;
    /** @var Adjustment[] */
    private array $adjustments = [];

    public function __construct(float $base) {}

    public function addMultiplier(string $rule, float $value): void
    {
        $this->factor *= $value;
        $this->adjustments[] = Adjustment::multiplier($rule, $value);
    }

    public function addBonus(string $rule, float $amount): void
    {
        $this->base += $amount;
        $this->adjustments[] = Adjustment::bonus($rule, $amount);
    }

    public function current(): float
    {
        return $this->base * $this->factor;
    }

    public function snapshot(float $spread = 0.1): ValuationResult
    {
        $price = $this->current();
        $min = $price * (1 - $spread);
        $max = $price * (1 + $spread);

        return new ValuationResult($this->base, $price, $min, $max, $this->adjustments);
    }
}