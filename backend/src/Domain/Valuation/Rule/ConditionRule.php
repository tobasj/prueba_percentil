<?php
declare(strict_types=1);

namespace App\Domain\Valuation\Rule;

use App\Domain\Valuation\Estimate;
use App\Domain\Valuation\ValuationInput;

final class ConditionRule implements RuleInterface
{
    private const MAP = ['new' => 1.5, 'good' => 1.2, 'fair' => 0.9];

    public function applies(ValuationInput $input): bool
    {
        return isset(self::MAP[$input->condition()]);
    }

    public function apply(Estimate $estimate, ValuationInput $input): void
    {
        $estimate->addMultiplier('condition', self::MAP[$input->condition()]);
    }
}