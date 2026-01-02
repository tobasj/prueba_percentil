<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

final class ValuationInput
{
    private string $brand;
    private string $category;
    private string $condition;

    public function __construct(string $brand, string $category, string $condition
    ) {
        $this->brand = trim($brand);
        $this->category = strtolower(trim($category));
        $this->condition = strtolower(trim($condition));
    }

    public function brand(): string { return $this->brand; }
    public function category(): string { return $this->category; }
    public function condition(): string { return $this->condition; }
}