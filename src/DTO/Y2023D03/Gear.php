<?php

declare(strict_types=1);

namespace App\DTO\Y2023D03;

final readonly class Gear
{
    public function __construct(
        private int $x,
        private int $y,
    ) {
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
