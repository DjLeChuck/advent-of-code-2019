<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D12 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $chars = [];
        $total = 0;

        foreach (str_split($data) as $char) {
            if ('-' === $char || is_numeric($char)) {
                $chars[] = $char;

                continue;
            }

            if (!empty($chars)) {
                $total += (int) implode('', $chars);

                $chars = [];
            }
        }

        return new Solution($total);
    }
}
