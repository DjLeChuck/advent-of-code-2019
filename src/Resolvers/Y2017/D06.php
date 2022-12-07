<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D06 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        // @todo Not working when running through this resolver, but if the exact same code is launched in a simple PHP script, the result is OK... /shrug
        $arr = array_map(static fn($item) => (int) $item, explode("\t", current($input)));
        $passed = [];
        $alreadySeen = false;
        $size = count($input);
        $steps = 0;
        $diff = 0;

        do {
            $max = max($arr);
            $index = array_search($max, $arr, true);

            $arr[$index] = 0; // blank current

            ++$index; // next block

            for ($x = $max; $x > 0; $x--) {
                if ($index >= $size) {
                    $index = 0;
                }

                ++$arr[$index];

                ++$index;
            }

            $hash = md5(serialize($arr));

            ++$steps;

            if (!\in_array($hash, $passed, true)) {
                $passed[] = $hash;
            } else {
                $diff = $steps - (array_search($hash, $passed, true) + 1);
                $alreadySeen = true;
            }
        } while (!$alreadySeen);

        return new Solution($steps, $diff);
    }
}
