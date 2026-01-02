<?php
declare(strict_types=1);

namespace App\UI\Http;

use App\Application\Valuation\EstimateValuationHandler;
use App\UI\Http\Validation\ValuationRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ValuationController
{
    private EstimateValuationHandler $handler;
    private ValuationRequestValidator $validator;

    public function __construct(
        EstimateValuationHandler $handler,
        ValuationRequestValidator $validator
    ) {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function estimate(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];

        [$errors, $req] = $this->validator->validate($payload);
        if ($errors) {
            return new JsonResponse(['message' => 'Invalid input', 'errors' => $errors], 400);
        }

        $res = $this->handler->handle($req);
        return new JsonResponse($res->toArray(), 200);
    }
}