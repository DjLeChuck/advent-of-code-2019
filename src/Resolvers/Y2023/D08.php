<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\DTO\Y2023D08\Node;
use App\Resolvers\ResolverInterface;

class D08 implements ResolverInterface
{
    private int $position = -1;

    public function resolve(array $input): Solution
    {
        /** @var array<int, Node> $nodes */
        $nodes = [];
        $path = str_split(array_shift($input));
        $partTwoCurrentNodes = [];

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            $matches = [];
            preg_match('/^([A-Z0-9]{3}) = \(([A-Z0-9]{3}), ([A-Z0-9]{3})\)$/', $row, $matches);

            $nodes[$matches[1]] = new Node($matches[1], $matches[2], $matches[3]);

            if (str_ends_with($matches[1], 'A')) {
                $partTwoCurrentNodes[] = $nodes[$matches[1]];
            }
        }

        // Part one
        $nbSteps = 0;
        $currentNode = $nodes['AAA'];

        while (!str_ends_with($currentNode->getName(), 'Z')) {
            $direction = $this->getDirection($path);
            $currentNode = $nodes[$currentNode->getDestinationName($direction)];
            ++$nbSteps;
        }

        // Part two
        $steps = array_fill(0, \count($partTwoCurrentNodes), 0);

        foreach ($partTwoCurrentNodes as $i => $currentNode) {
            while (!str_ends_with($currentNode->getName(), 'Z')) {
                $direction = $this->getDirection($path);
                $currentNode = $nodes[$currentNode->getDestinationName($direction)];
                ++$steps[$i];
            }
        }

        return new Solution($nbSteps, array_reduce($steps, [$this, 'lcm'], 1));
    }

    private function getDirection(array $path): string
    {
        ++$this->position;

        if ($this->position === \count($path)) {
            $this->position = 0;
        }

        return $path[$this->position];
    }

    private function gcd(float|int $a, float|int $b): float|int
    {
        return ($a % $b) ? $this->gcd($b, $a % $b) : $b;
    }

    private function lcm(float|int $a, float|int $b): float|int
    {
        return abs($a * $b) / $this->gcd($a, $b);
    }
}
