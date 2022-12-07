<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        array_pop($input); // Retrait de la dernière ligne vide parasite

        $tab = $input;
        $tab2 = $input;
        $steps = 0;
        $steps2 = 0;
        $total = count($input);
        $x = 0;
        $x2 = 0;

        do {
            // Valeur actuelle
            $value = (int) $tab[$x];

            // Augmentation de cette dernière
            ++$tab[$x];

            // Avance jusqu'à la valeur avant modification
            $x += $value;

            // Nombre d'étapes
            ++$steps;
        } while ($x < $total);

        // Part 2: 19759170 -> too low

        do {
            // Valeur actuelle
            $value2 = (int) $tab2[$x2];

            // Augmentation de cette dernière
            if ($value2 >= 3) {
                --$tab2[$x2];
            } else {
                ++$tab2[$x2];
            }

            // Avance jusqu'à la valeur avant modification
            $x2 += $value2;

            // Nombre d'étapes
            ++$steps2;
        } while ($x2 < $total);

        return new Solution($steps, $steps2);
    }
}
