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
        $partTwo = 0;

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            $matches = [];
            preg_match('/Game (\d+): (.*)/', $row, $matches);
            $game = $matches[1];
            $rounds = explode(';', $matches[2]);
            $nbValid = 0;

            $maxCubes = [
                'red'   => 0,
                'green' => 0,
                'blue'  => 0,
            ];

            foreach ($rounds as $cubes) {
                $matches = [];
                preg_match_all('/(\d+) (blue|red|green)/', $cubes, $matches);

                $result = array_combine($matches[2], array_map('\intval', $matches[1]));
                $validColors = 0;

                foreach ($result as $color => $value) {
                    $maxCubes[$color] = max($maxCubes[$color], $value);

                    if ($value <= self::NUMBER_ALLOWED_CUBES[$color]) {
                        ++$validColors;
                    }
                }

                if (\count($result) === $validColors) {
                    ++$nbValid;
                }
            }

            if (\count($rounds) === $nbValid) {
                $partOne += $game;
            }

            $partTwo += array_reduce($maxCubes, static fn(int $carry, int $item) => $carry * $item, 1);
        }

        return new Solution($partOne, $partTwo);
    }
}
