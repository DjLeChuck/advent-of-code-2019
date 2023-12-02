<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    private const WORDS = [
        'one'   => '1',
        'two'   => '2',
        'three' => '3',
        'four'  => '4',
        'five'  => '5',
        'six'   => '6',
        'seven' => '7',
        'eight' => '8',
        'nine'  => '9',
    ];

    public function resolve(array $input): Solution
    {
        $totalOne = 0;
        $totalTwo = 0;
        $secondPartPattern = '/(?=(\d|' . implode('|', array_keys(self::WORDS)) . '))/';

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            $numbers = [];
            preg_match_all('/(\d)/', $row, $numbers);

            $totalOne += (int) (current($numbers[0]) . end($numbers[0]));

            $numbers = [];
            preg_match_all($secondPartPattern, $row, $numbers);

            // Transform matched words into numbers
            foreach ($numbers[1] as &$number) {
                $number = self::WORDS[$number] ?? $number;
            }
            unset($number);

            $totalTwo += (int) (current($numbers[1]) . end($numbers[1]));
        }

        return new Solution($totalOne, $totalTwo);
    }
}
