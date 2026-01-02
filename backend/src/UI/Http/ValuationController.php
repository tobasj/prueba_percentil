<?php
declare(strict_types=1);

namespace App\UI\Http;

use App\Application\Valuation\EstimateValuationHandler;
use App\Application\Valuation\ValuationRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ValuationController
{
    private EstimateValuationHandler $handler;
    /**
     * @param EstimateValuationHandler $handler
     */
    public function __construct(EstimateValuationHandler $handler) {
        $this->handler = $handler;
    }

    #[Route('/api/v1/valuation/estimate', methods: ['POST'])]
    public function estimate(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];
        foreach (['brand','category','condition'] as $field) {
            if (empty($payload[$field])) {
                return new JsonResponse(['message' => "Missing field $field"], 400);
            }
        }
        $req = new ValuationRequest(
            (string)$payload['brand'],
            (string)$payload['category'],
            (string)$payload['condition']
        );
        $res = $this->handler->handle($req);

        return new JsonResponse($res->toArray(), 200);
    }
}