<?php
declare(strict_types=1);

namespace App\Domain\Valuation\Rule;

use App\Domain\Valuation\Estimate;
use App\Domain\Valuation\ValuationInput;
use App\Infrastructure\Persistence\BrandFactorRepository;

final class BrandRule implements RuleInterface
{
    public function __construct(BrandFactorRepository $repo) {}

    public function applies(ValuationInput $input): bool
    {
        return true;
    }

    public function apply(Estimate $estimate, ValuationInput $input): void
    {
        $factor = $this->repo->forBrand($input->brand());
        $estimate->addMultiplier('brand', $factor);
    }
}