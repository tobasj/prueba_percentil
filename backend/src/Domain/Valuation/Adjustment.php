<?php
declare(strict_types=1);

namespace App\Domain\Valuation;

final class Adjustment
{
    private string $rule;
    private string $type;
    private float $value;

    private function __construct(string $rule, string $type, float $value) {}

    public static function multiplier(string $rule, float $value): self { return new self($rule, 'multiplier', $value); }
    public static function bonus(string $rule, float $value): self { return new self($rule, 'bonus', $value); }
    public static function cap(string $rule, float $value): self { return new self($rule, 'cap', $value); }
    public static function floor(string $rule, float $value): self { return new self($rule, 'floor', $value); }

    public function rule(): string { return $this->rule; }
    public function type(): string { return $this->type; }
    public function value(): float { return $this->value; }
}