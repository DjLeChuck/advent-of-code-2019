<?php

declare(strict_types=1);

namespace App\DTO;

class Solution
{
    public function __construct(
        private readonly ?string $firstPart = null,
        private readonly ?string $secondPart = null
    ) {
    }

    public function getFirstPart(): ?string
    {
        return $this->firstPart;
    }

    public function getSecondPart(): ?string
    {
        return $this->secondPart;
    }
}
