<?php

declare(strict_types=1);

namespace App\DTO\Y2023D08;

final readonly class Node
{
    public function __construct(
        private string $name,
        private string $left,
        private string $right,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLeft(): string
    {
        return $this->left;
    }

    public function getRight(): string
    {
        return $this->right;
    }

    public function getDestinationName(string $direction): string
    {
        return match ($direction) {
            'L' => $this->left,
            'R' => $this->right,
            default => throw new \InvalidArgumentException('Unkonwn direction ' . $direction),
        };
    }
}
