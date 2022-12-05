<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    public function resolve(array $input): void
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

        dump('Max calories: '.end($calories));

        $topThree = array_slice($calories, -3);

        dump('Top three calories: '.array_reduce($topThree, static fn($x, $y) => $y += $x, 0));
    }
}
