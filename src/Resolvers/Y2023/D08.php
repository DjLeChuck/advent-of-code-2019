<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\DTO\Y2023D08\Node;
use App\Resolvers\ResolverInterface;

class D08 implements ResolverInterface
{
    /** @var array<int, Node> */
    private array $nodes = [];

    public function resolve(array $input): Solution
    {
        $path = str_split(array_shift($input));

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            $matches = [];
            preg_match('/^([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)$/', $row, $matches);

            $this->nodes[$matches[1]] = new Node($matches[1], $matches[2], $matches[3]);
        }

        $nbSteps = 0;
        $currentNode = $this->nodes['AAA'];

        do {
            foreach ($path as $direction) {
                $currentNode = $this->nodes[$currentNode->getDestinationName($direction)];
                ++$nbSteps;

                if ('ZZZ' === $currentNode->getName()) {
                    break 2;
                }
            }
        } while ('ZZZ' !== $currentNode->getName());

        return new Solution($nbSteps);
    }
}
