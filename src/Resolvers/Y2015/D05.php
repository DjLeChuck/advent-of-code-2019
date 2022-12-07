<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $valid = 0;

        foreach ($input as $str) {
            $valid += (int) $this->isValid($str);
        }

        return new Solution($valid);
    }

    private function isValid(string $str): bool
    {
        return (
            // three vowels
            preg_match('`(\w*[aeiou]\w*){3,}`', $str) &&
            // one repeating letter
            preg_match('`\w*(\w)\1\w*`', $str) &&
            // no forbidden sequence
            preg_match('`^((?!ab|cd|pq|xy)\w)*$`', $str)
        );
    }
}
