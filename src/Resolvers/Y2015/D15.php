<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D15 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $ingredients = [];
        $ratio = 100 / count($input);

        foreach ($input as $line) {
            $matches = [];

            preg_match(
                '`([a-zA-Z]*): capacity (-?\d*), durability (-?\d*), flavor (-?\d*), texture (-?\d*), calories (-?\d*)`',
                $line,
                $matches
            );

            $ingredients[$matches[1]] = [
                'capacity'   => (int) $matches[2],
                'durability' => (int) $matches[3],
                'flavor'     => (int) $matches[4],
                'texture'    => (int) $matches[5],
                'calories'   => (int) $matches[6],
                'ratio'      => $ratio,
            ];
        }

        $ratio = 100 / count($ingredients);
        $continue = true;

        do {
            $properties = [
                'capacity'   => 0,
                'durability' => 0,
                'flavor'     => 0,
                'texture'    => 0,
                'calories'   => 0,
            ];

            foreach ($ingredients as $data) {
                $properties['capacity'] += $data['capacity'] * $data['ratio'];
                $properties['durability'] += $data['durability'] * $data['ratio'];
                $properties['flavor'] += $data['flavor'] * $data['ratio'];
                $properties['texture'] += $data['texture'] * $data['ratio'];
            }

            dump($properties);

            $continue = false;
        } while ($continue);

        return new Solution();
    }
}
