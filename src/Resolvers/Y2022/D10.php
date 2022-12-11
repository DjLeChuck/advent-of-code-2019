<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D10 implements ResolverInterface
{
    private const NOOP = 'noop';

    private int $cycle = 0;
    private int $x = 1;
    private int $signalStrength = 0;
    private static array $interestingSignals = [20, 60, 100, 140, 180, 220];

    public function resolve(array $input): Solution
    {
        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            ++$this->cycle;

            $this->analyzeSignal();

            if (self::NOOP !== $row) {
                [, $size] = explode(' ', $row);

                $this->addInstruction((int) $size);
            }
        }

        return new Solution($this->signalStrength);
    }

    private function addInstruction(int $size): void
    {
        ++$this->cycle;

        $this->analyzeSignal();

        $this->x += $size;
    }

    private function analyzeSignal(): void
    {
        if (!\in_array($this->cycle, self::$interestingSignals, true)) {
            return;
        }

        $this->signalStrength += $this->cycle * $this->x;
    }
}
