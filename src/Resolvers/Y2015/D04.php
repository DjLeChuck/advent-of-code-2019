<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D04 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $number = 0;
        $numberOne = null;

        do {
            set_time_limit(1);

            $hash = md5($data.++$number);

            if (null === $numberOne && str_starts_with($hash, '00000')) {
                $numberOne = $number;
            }
        } while (!str_starts_with($hash, '000000'));

        return new Solution($numberOne, $number);
    }
}
