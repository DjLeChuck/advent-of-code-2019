<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D06 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $signal = str_split(current($input));

        return new Solution($this->analyzeSignal($signal, 4), $this->analyzeSignal($signal, 14));
    }

    private function analyzeSignal(array $signal, int $bufferSize): int
    {
        foreach ($signal as $index => $char) {
            $buffer[] = $char;

            if ($bufferSize === \count($buffer)) {
                if ($buffer === array_unique($buffer)) {
                    return $index + 1;
                }

                array_shift($buffer);
            }
        }

        throw new \InvalidArgumentException('Unprocessable signal!');
    }
}
