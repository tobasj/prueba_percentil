<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

final class ValuationResult
{
    /**
     * @param Adjustment[] $adjustments
     */
    public function __construct(float $base, float $price, float $min, float $max, array $adjustments
    ) {}

    public function base(): float { return $this->base; }
    public function price(): float { return $this->price; }
    public function min(): float { return $this->min; }
    public function max(): float { return $this->max; }
    
    /** @return Adjustment[] */
    public function adjustments(): array { return $this->adjustments; }
}