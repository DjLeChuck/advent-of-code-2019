<?php

declare(strict_types=1);

namespace App\DTO;

class Solution
{
    public function __construct(
        private readonly string|int|null $firstPart = null,
        private readonly string|int|null $secondPart = null
    ) {
    }

    public function getFirstPart(): string|int|null
    {
        return $this->firstPart;
    }

    public function getSecondPart(): string|int|null
    {
        return $this->secondPart;
    }
}
