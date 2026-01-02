<?php
declare(strict_types=1);

namespace App\Domain\Valuation\Rule;

use App\Domain\Valuation\Estimate;
use App\Domain\Valuation\ValuationInput;

final class FloorCeilingRule implements RuleInterface
{
    private float $floor;
    private float $ceiling;
    public function __construct(float $floor, float $ceiling) {}

    public function applies(ValuationInput $input): bool
    {
        return true;
    }

    public function apply(Estimate $estimate, ValuationInput $input): void
    {
        $price = $estimate->current();
        if ($price < $this->floor) {
            $estimate->addBonus('floor', $this->floor - $price);
        }
        if ($price > $this->ceiling) {
            $estimate->addBonus('ceiling', $this->ceiling - $price);
        }
    }
}