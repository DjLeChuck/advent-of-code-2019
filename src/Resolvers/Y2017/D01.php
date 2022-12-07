<?php

declare(strict_types=1);

namespace App\Resolvers\Y2017;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $arr = str_split(current($input));
        $sum = 0;
        $length = count($arr);
        $mid = floor($length / 2);
        $sum2 = 0;

        foreach ($arr as $i => $iValue) {
            $number = (int) $iValue;

            // Partie 1
            if ($i === $length - 1) {
                $next = (int) reset($arr);
            } else {
                $next = (int) $arr[$i + 1];
            }

            if ($number === $next) {
                $sum += $number;
            }

            // Partie 2
            if ($i < $mid) {
                $other = (int) $arr[$mid + $i];
            } else {
                $other = (int) $arr[$i - $mid];
            }

            if ($number === $other) {
                $sum2 += $number;
            }
        }

        return new Solution($sum, $sum2);
    }
}
