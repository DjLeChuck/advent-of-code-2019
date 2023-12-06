<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    /**
     * @var array{
     *     seeds: int[],
     *     maps: array{
     *      seed-to-soil: array<int, array{destination: int, source: int, length: int}>,
     *      soil-to-fertilizer: array<int, array{destination: int, source: int, length: int}>,
     *      fertilizer-to-water: array<int, array{destination: int, source: int, length: int}>,
     *      water-to-light: array<int, array{destination: int, source: int, length: int}>,
     *      light-to-temperature: array<int, array{destination: int, source: int, length: int}>,
     *      temperature-to-humidity: array<int, array{destination: int, source: int, length: int}>,
     *      humidity-to-location: array<int, array{destination: int, source: int, length: int}>,
     *     }
     *  }
     */
    private array $almanach = [];

    public function resolve(array $input): Solution
    {
        $input = implode("\n", $input);
        $matches = [];

        preg_match_all('/^(.* map|seeds):|((\d+ ?)*)/m', $input, $matches, PREG_SET_ORDER);

        $currentKey = '';

        foreach ($matches as $match) {
            if (!empty($match[1])) {
                $currentKey = rtrim(trim($match[1]), ' map');

                if ('seeds' === $match[1]) {
                    $this->almanach[$currentKey] = [];
                } else {
                    $this->almanach['maps'][$currentKey] = [];
                }
            } elseif (!empty($match[2])) {
                $values = array_map('\intval', explode(' ', trim($match[2])));
                if ('seeds' === $currentKey) {
                    $this->almanach[$currentKey] = $values;
                } else {
                    $this->almanach['maps'][$currentKey][] = array_combine(
                        ['destination', 'source', 'length'],
                        $values
                    );
                }
            }
        }

        $maps = array_keys($this->almanach['maps']);
        $partOne = INF;

        foreach ($this->almanach['seeds'] as $seed) {
            $value = $seed;

            foreach ($maps as $map) {
                $value = $this->transformXToY($value, $map);
            }

            $partOne = min($partOne, $value);
        }

        $partTwo = [];

        foreach (array_chunk($this->almanach['seeds'], 2) as [$start, $length]) {
            $range = [[$start, $start + $length]];

            foreach ($maps as $map) {
                $range = $this->applyRange($range, $this->almanach['maps'][$map]);
            }

            $partTwo[] = min($range)[0];
        }

        return new Solution($partOne, min($partTwo));
    }

    private function applyRange($range, $steps): array
    {
        $interRange = [];

        foreach ($steps as $tuple) {
            $destination = $tuple['destination'];
            $source = $tuple['source'];
            $sourceEnd = $source + $tuple['length'];
            $otherRanges = [];

            while (!empty($range)) {
                $current = array_pop($range);
                [$st, $ed] = $current;

                $before = [$st, min($ed, $source)];
                $inter = [max($st, $source), min($sourceEnd, $ed)];
                $after = [max($sourceEnd, $st), $ed];

                if ($before[1] > $before[0]) {
                    $otherRanges[] = $before;
                }

                if ($inter[1] > $inter[0]) {
                    $interRange[] = [$inter[0] - $source + $destination, $inter[1] - $source + $destination];
                }

                if ($after[1] > $after[0]) {
                    $otherRanges[] = $after;
                }
            }

            $range = $otherRanges;
        }

        return array_merge($interRange, $range);
    }

    private function transformXToY(int $value, string $map): int
    {
        foreach ($this->almanach['maps'][$map] as $range) {
            if ($value >= $range['source'] && $value <= $range['source'] + $range['length']) {
                return $range['destination'] + $value - $range['source'];
            }
        }

        return $value;
    }
}
