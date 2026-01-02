<?php
declare(strict_types=1);

namespace App\Application\Valuation;

final class ValuationRequest
{
    public string $brand;
    public string $category;
    public string $condition;
    /**
     * @param string $brand
     * @param string $category
     * @param string $condition
     */
    public function __construct(string $brand, string $category, string $condition)
    {
        $this->brand = trim($brand) ?? '';
        $this->category = trim($category) ?? '';
        $this->condition = trim($condition) ?? 'fair';
    }
}