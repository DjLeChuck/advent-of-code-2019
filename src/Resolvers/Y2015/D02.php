<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D02 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $total = 0;
        $totalB = 0;

        foreach ($input as $size) {
            [$l, $w, $h] = explode('x', $size);
            $l = (int) $l;
            $w = (int) $w;
            $h = (int) $h;
            $min = min($l * $w, $w * $h, $h * $l);
            $sizes = [$l, $w, $h];

            sort($sizes);
            array_pop($sizes);

            $total += 2 * $l * $w + 2 * $w * $h + 2 * $h * $l + $min;
            $sizes = array_values($sizes);
            $totalB += 2 * $sizes[0] + 2 * $sizes[1] + $l * $w * $h;
        }

        return new Solution($total, $totalB);
    }
}
