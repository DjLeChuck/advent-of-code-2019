<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D08 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $trees = [];

        foreach ($input as $row => $range) {
            if (empty($range)) {
                continue;
            }

            foreach (str_split($range) as $column => $size) {
                $trees[$row][$column] = (int) $size;
            }
        }

        $nbVisibles = 0;

        dump($input);

        // Process top and bottom
        $ranges = ['top' => [], 'bottom' => []];

        foreach ($trees as $row => $range) {
            $nb = \count($range);

            for ($x = 0; $x < $nb; ++$x) {
                $ranges['top'][$x][$row] = $range[$x];
            }
        }

        foreach ($ranges['top'] as $range) {
            $ranges['bottom'][] = array_reverse($range);
        }

        $nbVisibles += $this->countVisible($ranges['top']);
        dump('top: '.$this->countVisible($ranges['top']));
        $nbVisibles += $this->countVisible($ranges['bottom']);
        dump('bottom: '.$this->countVisible($ranges['bottom']));

        // Process left and right
        $ranges = ['left' => [], 'right' => []];

        foreach ($trees as $range) {
            $ranges['left'][] = $range;
            $ranges['right'][] = array_reverse($range);
        }

        $nbVisibles += $this->countVisible($ranges['left']);
        dump('left: '.$this->countVisible($ranges['left']));
        $nbVisibles += $this->countVisible($ranges['right']);
        dump('right: '.$this->countVisible($ranges['right']));

        dump($nbVisibles);

        return new Solution();
    }

    private function countVisible(array $ranges): int
    {
        $nbVisibles = 0;

        foreach ($ranges as $range) {
            $max = -1;

            foreach ($range as $size) {
                if ($size > $max) {
                    ++$nbVisibles;
                }

                $max = max($size, $max);
            }
        }

        return $nbVisibles;
    }
}
