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
        $minLocation = INF;

        foreach ($this->almanach['seeds'] as $seed) {
            $value = $seed;

            foreach ($maps as $map) {
                $value = $this->transformXToY($value, $map);
            }

            $minLocation = min($minLocation, $value);
        }

        return new Solution($minLocation);
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
