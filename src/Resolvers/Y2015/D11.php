<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D11 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $data = current($input);
        $new = '';

        foreach (str_split($data) as $char) {
            $new .= chr(ord($char) + 1);
        }

        dump($new);

        return new Solution();
    }
}
