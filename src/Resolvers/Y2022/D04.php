<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D04 implements ResolverInterface
{
    public function resolve(array $input): void
    {
        $firstNbRanges = 0;
        $secondNbRanges = 0;

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            [$first, $second] = explode(',', $row);
            [$fMin, $fMax] = explode('-', $first);
            [$sMin, $sMax] = explode('-', $second);
            $fRange = range($fMin, $fMax);
            $sRange = range($sMin, $sMax);
            $intersection = array_intersect($fRange, $sRange);

            if (\count($intersection) === \count($fRange) || \count($intersection) === \count($sRange)) {
                ++$firstNbRanges;
            }

            if (0 < \count($intersection)) {
                ++$secondNbRanges;
            }
        }

        dump('First answer: '.$firstNbRanges);
        dump('Second answer: '.$secondNbRanges);
    }
}
