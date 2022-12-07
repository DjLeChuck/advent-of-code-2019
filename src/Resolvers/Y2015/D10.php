<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D10 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $one = $this->calculate($data, 40);

        return new Solution(strlen($one), strlen($this->calculate($one, 10)));
    }

    private function calculate(string $input, int $nbIterations): string
    {
        for ($x = 1; $x <= $nbIterations; $x++) {
            $new = '';
            $count = 0;
            $prev = '';

            foreach (str_split($input) as $char) {
                if ($prev !== $char && 0 < $count) {
                    $new .= $count.$prev;
                    $count = 0;
                }

                $count++;

                $prev = $char;
            }

            $input = $new.$count.$prev;
        }

        return $input;
    }
}
