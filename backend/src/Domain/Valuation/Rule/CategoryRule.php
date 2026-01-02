<?php
declare(strict_types=1);

namespace App\Domain\Valuation\Rule;

use App\Domain\Valuation\Estimate;
use App\Domain\Valuation\ValuationInput;

final class CategoryRule implements RuleInterface
{
    private array $map;

    public function __construct(array $map = ['dress' => 1.1, 'shoes' => 1.2, 'bag' => 1.15])
    {
        $this->map = $map;
    }

    public function applies(ValuationInput $input): bool
    {
        return isset($this->map[$input->category()]);
    }

    public function apply(Estimate $estimate, ValuationInput $input): void
    {
        $estimate->addMultiplier('category', $this->map[$input->category()]);
    }
}