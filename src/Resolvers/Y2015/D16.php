<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D16 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $needs = [
            'children'    => 3,
            'cats'        => 7,
            'samoyeds'    => 2,
            'pomeranians' => 3,
            'akitas'      => 0,
            'vizslas'     => 0,
            'goldfish'    => 5,
            'trees'       => 3,
            'cars'        => 2,
            'perfumes'    => 1,
        ];
        $signs = [
            'children'    => '=',
            'cats'        => '>',
            'samoyeds'    => '=',
            'pomeranians' => '<',
            'akitas'      => '=',
            'vizslas'     => '=',
            'goldfish'    => '<',
            'trees'       => '>',
            'cars'        => '=',
            'perfumes'    => '=',
        ];
        $auntNumber = 0;
        $realAuntNumber = 0;

        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }

            $matches = [];

            preg_match(
                '`^Sue (\d{1,3}): ([a-z]*): (\d*), ([a-z]*): (\d*), ([a-z]*): (\d*)$`',
                $line,
                $matches
            );

            $goodRealAunt = true;
            $good_aunt = true;
            $auntData = [
                $matches[2] => (int) $matches[3],
                $matches[4] => (int) $matches[5],
                $matches[6] => (int) $matches[7],
            ];

            foreach ($needs as $key => $value) {
                if (!array_key_exists($key, $auntData)) {
                    continue;
                }

                if ($value !== $auntData[$key]) {
                    $good_aunt = false;
                }

                switch ($signs[$key]) {
                    case '<':
                        $goodRealAunt &= ($value > $auntData[$key]);
                        break;
                    case '>':
                        $goodRealAunt &= ($value < $auntData[$key]);
                        break;
                    case '=':
                        $goodRealAunt &= ($value === $auntData[$key]);
                        break;
                }
            }

            if ($good_aunt) {
                $auntNumber = $matches[1];
            }

            if ($goodRealAunt) {
                $realAuntNumber = $matches[1];
            }
        }

        return new Solution($auntNumber, $realAuntNumber);
    }
}
