<?php
declare(strict_types=1);

namespace App\Application\Valuation;

use App\Domain\Valuation\ValuationInput;
use App\Domain\Valuation\ValuationService;

final class EstimateValuationHandler
{
    private ValuationService $service;
    /**
     * @param ValuationService $service
     */
    public function __construct(ValuationService $service) {
        $this->service = $service;
    }

    public function handle(ValuationRequest $req): ValuationResponse
    {
        $input = new ValuationInput($req->brand, $req->category, $req->condition);
        $result = $this->service->estimate($input);
        return ValuationResponse::fromResult($result);
    }
}