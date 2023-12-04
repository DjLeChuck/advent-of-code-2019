<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D04 implements ResolverInterface
{

    public function resolve(array $input): Solution
    {
        $totalOne = 0;
        $nbCards = array_fill(0, \count(array_filter($input)), 1);

        foreach ($input as $i => $cardData) {
            if (empty($cardData)) {
                continue;
            }

            $matches = [];
            preg_match('`: ([^|]*) \| (.*)`', $cardData, $matches);

            $winNumbers = array_map('\intval', array_filter(explode(' ', $matches[1])));
            $getNumbers = array_map('\intval', array_filter(explode(' ', $matches[2])));
            $nbMatch = \count($winNumbers) - \count(array_diff($winNumbers, $getNumbers));

            if (0 === $nbMatch) {
                continue;
            }

            // Part one
            $result = 1;

            for ($x = 0; $x < $nbMatch - 1; $x++) {
                $result *= 2;
            }

            $totalOne += $result;

            // Part two
            for ($y = 1; $y <= $nbCards[$i]; $y++) {
                for ($x = 1; $x <= $nbMatch; $x++) {
                    ++$nbCards[$i + $x];
                }
            }
        }

        return new Solution($totalOne, array_sum($nbCards));
    }
}
