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
    private array $pendingInstructions = [];
    private int $nextInstructionCycle = 0;
    private static array $interestingSignals = [20, 60, 100, 140, 180, 220];

    public function resolve(array $input): Solution
    {
        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            ++$this->cycle;

            // $x = $this->x;

            if (self::NOOP !== $row) {
                [, $size] = explode(' ', $row);

                $this->addInstruction((int) $size);
            }

            $this->analyzeSignal();
            $this->processInstructions();
            // dump('cycle '.$this->cycle.' - begin: '.$x.' - end: '.$this->x);
        }

        $this->processPendingInstructions();

        return new Solution($this->signalStrength);
    }

    private function addInstruction(int $size): void
    {
        if (!empty($this->pendingInstructions)) {
            $executionCycle = max(array_keys($this->pendingInstructions)) + 2;
        } else {
            $executionCycle = $this->cycle + 1;
        }

        $this->pendingInstructions[$executionCycle] = $size;
    }

    private function processInstructions(): void
    {
        if (!isset($this->pendingInstructions[$this->cycle])) {
            return;
        }

        $this->x += $this->pendingInstructions[$this->cycle];
        unset($this->pendingInstructions[$this->cycle]);
    }

    private function analyzeSignal(): void
    {
        if (!\in_array($this->cycle, self::$interestingSignals, true)) {
            return;
        }

        dump($this->cycle.': '.$this->x);

        $this->signalStrength += $this->cycle * $this->x;
    }

    private function processPendingInstructions(): void
    {
        $maxCycle = max(array_keys($this->pendingInstructions));

        for ($i = $this->cycle; $i <= $maxCycle; ++$i) {
            $this->cycle = $i;

            $this->analyzeSignal();
            $this->processInstructions();
        }
    }
}
