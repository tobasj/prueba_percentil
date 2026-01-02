<?php
declare(strict_types=1);

namespace App\Application\Valuation;

use App\Domain\Valuation\ValuationResult;

final class ValuationResponse
{
    public float $base;
    public float $price;
    public float $min;
    public float $max;
    public array $adjustments;

    public function __construct(float $base, float $price, float $min, float $max, array $adjustments)
    {
        $this->base = $base;
        $this->price = $price;
        $this->min = $min;
        $this->max = $max;
        $this->adjustments = $adjustments;
    }

    public static function fromResult(ValuationResult $res): self
    {
        return new self(
            $res->base(),
            $res->price(),
            $res->min(),
            $res->max(),
            array_map(
                fn($a) => ['rule'=>$a->rule(), 'type'=>$a->type(), 'value'=>$a->value()],
                $res->adjustments()
            )
        );
    }

    public function toArray(): array
    {
        return [
            'base' => $this->base,
            'price' => $this->price,
            'min' => $this->min,
            'max' => $this->max,
            'adjustments' => $this->adjustments,
        ];
    }
}