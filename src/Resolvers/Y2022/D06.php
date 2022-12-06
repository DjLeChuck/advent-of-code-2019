<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D06 implements ResolverInterface
{
    public function resolve(array $input): void
    {
        $signal = str_split(current($input));

        dump('First answer: '.$this->analyzeSignal($signal, 4));
        dump('Second answer: '.$this->analyzeSignal($signal, 14));
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
