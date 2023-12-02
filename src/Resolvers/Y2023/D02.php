<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D02 implements ResolverInterface
{
    private const NUMBER_ALLOWED_CUBES = [
        'red'   => 12,
        'green' => 13,
        'blue'  => 14,
    ];

    public function resolve(array $input): Solution
    {
        $partOne = 0;

        foreach ($input as $game) {
            if (empty($game)) {
                continue;
            }

            $matches = [];
            preg_match('/Game (\d+): (.*)/', $game, $matches);
            $game = $matches[1];
            $rounds = explode(';', $matches[2]);
            $nbValid = 0;

            foreach ($rounds as $cubes) {
                $matches = [];
                preg_match_all('/(\d+) (blue|red|green)/', $cubes, $matches);

                $result = array_combine($matches[2], array_map('\intval', $matches[1]));

                foreach ($result as $color => $value) {
                    if ($value > self::NUMBER_ALLOWED_CUBES[$color]) {
                        break 2;
                    }
                }

                ++$nbValid;
            }

            if (\count($rounds) === $nbValid) {
                $partOne += $game;
            }
        }

        return new Solution($partOne);
    }
}
