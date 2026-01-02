<?php
declare(strict_types=1);

namespace App\Domain\Valuation\Rule;

use App\Domain\Valuation\Estimate;
use App\Domain\Valuation\ValuationInput;

interface RuleInterface
{
    public function applies(ValuationInput $input): bool;
    public function apply(Estimate $estimate, ValuationInput $input): void;
}