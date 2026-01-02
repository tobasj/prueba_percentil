<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

interface BrandFactorRepository
{
    public function forBrand(string $brand): float;
}