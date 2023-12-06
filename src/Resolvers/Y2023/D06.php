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
        /** @var array{Time: int[], Distance: int[]} $sheetTwo */
        $sheetTwo = [];

        foreach ($matches as $match) {
            $key = trim($match[1]);
            $values = array_filter(array_map('\intval', explode(' ', trim($match[2]))));
            $sheet[$key] = [...$values];
            $sheetTwo[$key] = (int) implode('', $values);
        }

        $totalPartOne = [];

        foreach ($sheet['Time'] as $round => $duration) {
            $totalPartOne[] = $this->calculateBeatedRounds($duration, $sheet['Distance'][$round]);
        }

        return new Solution(
            array_reduce($totalPartOne, static fn(int $carry, int $value) => $carry * $value, 1),
            $this->calculateBeatedRounds($sheetTwo['Time'], $sheetTwo['Distance'])
        );
    }

    private function calculateBeatedRounds(int $duration, int $distance): int
    {
        $beatedRounds = 0;

        for ($x = $duration; $x > 0; $x--) {
            $newDistance = $x * ($duration - $x);

            if ($newDistance > $distance) {
                ++$beatedRounds;
            }
        }

        return $beatedRounds;
    }
}
