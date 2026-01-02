<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

final class InMemoryBrandFactorRepository implements BrandFactorRepository
{
    private array $factors;
    public function __construct(array $factors = ['Zara' => 1.10, 'H&M' => 1.05]) {
        $this->factors = $factors;
    }

    public function forBrand(string $brand): float
    {
        return $this->factors[$brand] ?? 1.0;
    }
}