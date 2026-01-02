<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

final class ValuationResult
{
    /**
     * @param Adjustment[] $adjustments
     */
    private float $base;
    private float $price;
    private float $min;
    private float $max;
    private array $adjustments;
    public function __construct(float $base, float $price, float $min, float $max, array $adjustments
    ) {
        $this->base = $base;
        $this->price = $price;
        $this->min = $min;
        $this->max = $max;
        $this->adjustments = $adjustments;
    }

    public function base(): float { return $this->base; }
    public function price(): float { return $this->price; }
    public function min(): float { return $this->min; }
    public function max(): float { return $this->max; }

    /** @return Adjustment[] */
    public function adjustments(): array { return $this->adjustments; }
}