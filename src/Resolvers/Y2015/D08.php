<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D08 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $a = 0;
        $b = 0;
        $c = 0;

        foreach ($input as $line) {
            $linebis = substr($line, 1);
            $linebis = substr($linebis, 0, -1);
            $linebis = str_replace(['\"', '\\\\'], '"', $linebis);
            $linebis = preg_replace('`(\\\\x[a-f0-9]{2})`', 'x', $linebis);
            $lineter = str_replace(['"', '\\'], ['""', '##'], $line);
            $a += strlen($line);
            $b += strlen($linebis);
            $c += strlen($lineter) + 2;
        }

        // wrong second part: $c - $a
        return new Solution($a - $b);
    }
}
