<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

use App\Domain\Valuation\Rule\RuleInterface;

final class ValuationService
{
    private float $base;
    private iterable $rules;

    public function __construct(iterable $rules, float $base = 100.0)
    {
        $this->rules = is_array($rules) ? $rules : iterator_to_array($rules);
    }

    public function estimate(ValuationInput $input): ValuationResult
    {
        $estimate = new Estimate($this->base);
        foreach ($this->rules as $rule) {
            if ($rule->applies($input)) {
                $rule->apply($estimate, $input);
            }
        }
        return $estimate->snapshot();
    }
}