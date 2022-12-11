<?php

declare(strict_types=1);

namespace App\DTO\Y2022D11;

class Item
{
    public function __construct(
        private string $worryLevel,
    ) {
    }

    public function getWorryLevel(): string
    {
        return $this->worryLevel;
    }

    public function setWorryLevel(string $worryLevel): void
    {
        $this->worryLevel = $worryLevel;
    }
}
