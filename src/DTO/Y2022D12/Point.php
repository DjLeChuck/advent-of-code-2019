<?php

declare(strict_types=1);

namespace App\DTO\Y2022D12;

use JMGQ\AStar\Node\NodeIdentifierInterface;

class Point implements NodeIdentifierInterface
{
    public function __construct(
        private readonly int $x,
        private readonly int $y
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

    public function getUniqueNodeId(): string
    {
        return $this->x.'x'.$this->y;
    }

    public function isEqualTo(Point $other): bool
    {
        return $this->getX() === $other->getX() && $this->getY() === $other->getY();
    }

    public function isDiagonal(Point $other): bool
    {
        $diagonals = [
            new Point($this->getX() - 1, $this->getY() + 1), // top left
            new Point($this->getX() + 1, $this->getY() + 1), // top right
            new Point($this->getX() - 1, $this->getY() - 1), // bottom left
            new Point($this->getX() + 1, $this->getY() - 1), // bottom right
        ];

        foreach ($diagonals as $point) {
            if ($point->getUniqueNodeId() === $other->getUniqueNodeId()) {
                return true;
            }
        }

        return false;
    }

    public function isAdjacentTo(Point $other): bool
    {
        return abs($this->getX() - $other->getX()) <= 1 && abs($this->getY() - $other->getY()) <= 1;
    }
}
