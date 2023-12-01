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

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            $i = 0;
            $secondRow = $row;

            while ($i <= mb_strlen($secondRow)) {
                foreach (self::WORDS as $word => $number) {
                    $wordLen = mb_strlen($word);

                    if ($word === mb_substr($secondRow, $i, $wordLen)) {
                        $secondRow = substr_replace($secondRow, $number, $i, $wordLen);
                        $i += mb_strlen($number) - 1;
                        break;
                    }
                }
                $i++;
            }

            $strSplit = str_split($row);
            $strSecondSplit = str_split($secondRow);

            $totalOne += (int) ($this->getFirstNumber($strSplit) . $this->getFirstNumber(array_reverse($strSplit)));
            $totalTwo += (int) (
                $this->getFirstNumber($strSecondSplit) . $this->getFirstNumber(array_reverse($strSecondSplit))
            );
        }

        return new Solution($totalOne, $totalTwo);
    }

    private function getFirstNumber(array $chars): string
    {
        foreach ($chars as $char) {
            if (is_numeric($char)) {
                return $char;
            }
        }

        throw new \InvalidArgumentException(sprintf('No number in the chars list: %s', implode('', $chars)));
    }
}
