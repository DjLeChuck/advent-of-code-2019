<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $calories = [];
        $index = 0;

        foreach ($input as $row) {
            // Ligne vide => changement d'elfe
            if ('' === $row) {
                ++$index;
            }

            if (!isset($calories[$index])) {
                $calories[$index] = 0;
            }

            $calories[$index] += (int) $row;
        }

        sort($calories);

        $firstAnswer = end($calories);

        $topThree = array_slice($calories, -3);

        return new Solution($firstAnswer, array_reduce($topThree, static fn($x, $y) => $y + $x, 0));
    }
}
