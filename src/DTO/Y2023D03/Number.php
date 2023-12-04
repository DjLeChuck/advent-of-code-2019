<?php

declare(strict_types=1);

namespace App\DTO\Y2023D03;

final class Number
{
    private array $xRange;

    public function __construct(
        private readonly int $value,
        private readonly int $x,
        private readonly int $y,
    ) {
        $this->xRange = [];

        for ($i = $x; $i < $this->x + \strlen((string) $this->value); $i++) {
            $this->xRange[] = $i;
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getXRange(): array
    {
        return $this->xRange;
    }

    public function __toString(): string
    {
        return sprintf('%u:%u', $this->x, $this->y);
    }
}
