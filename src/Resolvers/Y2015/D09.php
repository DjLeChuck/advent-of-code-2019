<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D09 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $map = [];

        foreach ($input as $line) {
            [$from, , $to, , $distance] = explode(' ', $line);

            if (!array_key_exists($from, $map)) {
                $map[$from] = [];
            }

            if (!\in_array($to, $map[$from], true)) {
                $map[$from][$to] = $distance;
            }
        }

        dump($map);

        return new Solution();
    }
}
