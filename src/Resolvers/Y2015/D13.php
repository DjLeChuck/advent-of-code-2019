<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D13 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $map = [];

        foreach ($input as $line) {
            $tmp = [];

            preg_match(
                '`^(?P<a>[a-zA-Z]+) would (?P<action>gain|lose) (?P<amount>\d+) happiness units by sitting next to (?P<b>[a-zA-Z]+)\.$`',
                $line,
                $tmp
            );

            $amount = 'gain' === $tmp['action'] ? $tmp['amount'] : -$tmp['amount'];

            $map[$tmp['a']][$tmp['b']] = (int) $amount;
        }

        $happiness = 0;

        foreach ($map as $a => $b_data) {
            $min = PHP_INT_MAX;
            $b = null;
            $amount = 0;

            foreach ($b_data as $newB => $amount) {
                if ($amount < $min) {
                    $b = $newB;
                    $min = $amount;
                }
            }

            $happiness += $amount;

            dump($a, $b, $amount);
        }

        // wrong first part: $happiness
        return new Solution();
    }
}
