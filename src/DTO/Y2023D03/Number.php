<?php

declare(strict_types=1);

namespace App\DTO\Y2023D03;

final readonly class Number
{
    public function __construct(
        private int $value,
        private int $x,
        private int $y,
    ) {
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
}
