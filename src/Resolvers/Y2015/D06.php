<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D06 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $map = ['one' => [], 'two' => []];

        for ($x = 0; $x <= 999; $x++) {
            $map['one'][$x] = [];
            $map['two'][$x] = [];

            for ($y = 0; $y <= 999; $y++) {
                $map['one'][$x][$y] = 0;
                $map['two'][$x][$y] = 0;
            }
        }

        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }

            $parts = explode(' ', str_replace('turn ', '', $line));
            $action = $parts[0];
            $coords = [
                explode(',', $parts[1]),
                explode(',', $parts[3]),
            ];

            for ($x = $coords[0][0]; $x <= $coords[1][0]; $x++) {
                for ($y = $coords[0][1]; $y <= $coords[1][1]; $y++) {
                    switch ($action) {
                        case 'on':
                            $map['one'][$x][$y] = 1;
                            $map['two'][$x][$y] += 1;
                            break;
                        case 'off':
                            $map['one'][$x][$y] = 0;
                            $map['two'][$x][$y] -= 1;
                            $map['two'][$x][$y] = max($map['two'][$x][$y], 0);
                            break;
                        case 'toggle':
                            $map['one'][$x][$y] = (int) !$map['one'][$x][$y];
                            $map['two'][$x][$y] += 2;
                            break;
                    }
                }
            }
        }

        $totalOne = 0;
        $totalTwo = 0;

        for ($x = 0; $x <= 999; $x++) {
            for ($y = 0; $y <= 999; $y++) {
                if (1 === $map['one'][$x][$y]) {
                    $totalOne++;
                }

                $totalTwo += $map['two'][$x][$y];
            }
        }

        return new Solution($totalOne, $totalTwo);
    }
}
