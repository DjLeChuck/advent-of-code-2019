<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D01 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $count = 1;
        $strlen = strlen($data);
        $basement = null;

        for ($i = 0; $i <= $strlen; $i++) {
            $count += '(' === $data[$i] ? 1 : -1;

            if (-1 === $count && null === $basement) {
                $basement = $i;
            }
        }

        return new Solution($count, $basement);
    }
}
