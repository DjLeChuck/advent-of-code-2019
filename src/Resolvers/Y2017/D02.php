<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D02 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $checksum = 0;
        $checksum2 = 0;

        foreach ($input as $row) {
            $values = explode("\t", $row);

            // Partie 1
            [$min, $max] = [min($values), max($values)];

            $checksum += (int) $max - (int) $min;

            // Partie 2
            foreach ($values as $key => $value) {
                foreach ($values as $keyTwo => $valueTwo) {
                    if ($key === $keyTwo) {
                        continue;
                    }

                    if (0 === $value % $valueTwo) {
                        $checksum2 += $value / $valueTwo;
                    }
                }
            }
        }

        return new Solution($checksum, $checksum2);
    }
}
