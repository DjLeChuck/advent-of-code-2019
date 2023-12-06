<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D06 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $input = implode("\n", $input);
        $pattern = '/^(.*):\\s*(.*)$/m';
        $matches = [];
        preg_match_all($pattern, $input, $matches, PREG_SET_ORDER);

        /** @var array{Time: int[], Distance: int[]} $sheet */
        $sheet = [];

        foreach ($matches as $match) {
            $key = trim($match[1]);
            $values = array_filter(array_map('\intval', explode(' ', trim($match[2]))));
            $sheet[$key] = [...$values];
        }

        $totalPartOne = [];

        foreach ($sheet['Time'] as $round => $duration) {
            $distance = $sheet['Distance'][$round];

            $beatedRounds = 0;

            for ($x = $duration; $x > 0; $x--) {
                $newDistance = $x * ($duration - $x);

                if ($newDistance > $distance) {
                    ++$beatedRounds;
                }
            }

            $totalPartOne[] = $beatedRounds;
        }

        return new Solution(array_reduce($totalPartOne, static fn(int $carry, int $value) => $carry * $value, 1));
    }
}
