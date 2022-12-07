<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D03 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $dataOne = str_split($data);
        $mapOne = ['0,0' => 1];
        $mapTwo = [['0,0' => 1], ['0,0' => 1]];
        $iOne = 0;
        $jOne = 0;
        $iTwo = [0 => 0, 1 => 0];
        $jTwo = [0 => 0, 1 => 0];
        $x = 0;

        foreach ($dataOne as $dir) {
            $xMod = $x % 2;

            switch ($dir) {
                case '>':
                    $iOne++;
                    $iTwo[$xMod]++;
                    break;
                case '^':
                    $jOne++;
                    $jTwo[$xMod]++;
                    break;
                case 'v':
                    $jOne--;
                    $jTwo[$xMod]--;
                    break;
                case '<':
                    $iOne--;
                    $iTwo[$xMod]--;
                    break;
            }

            if (!isset($mapOne[sprintf('%d,%d', $iOne, $jOne)])) {
                $mapOne[sprintf('%d,%d', $iOne, $jOne)] = 1;
            }

            $mapOne[sprintf('%d,%d', $iOne, $jOne)]++;

            if (!isset($mapTwo[$xMod][sprintf('%d,%d', $iTwo[$xMod], $jTwo[$xMod])])) {
                $mapTwo[$xMod][sprintf('%d,%d', $iTwo[$xMod], $jTwo[$xMod])] = 1;
            }

            $mapTwo[$xMod][sprintf('%d,%d', $iTwo[$xMod], $jTwo[$xMod])]++;

            $x++;
        }

        return new Solution(count($mapOne), count(array_merge($mapTwo[0], $mapTwo[1])));
    }
}
