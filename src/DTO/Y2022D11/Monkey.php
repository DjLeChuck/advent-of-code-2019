<?php

declare(strict_types=1);

namespace App\DTO\Y2022D11;

class Monkey
{
    private const WORRY_LEVEL_ADJUSTMENT_RATIO = '3';

    private int $nbInspectedObjects = 0;
    /** @var Item[] */
    private array $items = [];
    private string $operation;
    private int $divisionTest;
    private int $monkeyToThrowIfTrue;
    private int $monkeyToThrowIfFalse;

    public function getNbInspectedObjects(): int
    {
        return $this->nbInspectedObjects;
    }

    public function setItems(array $items): void
    {
        foreach ($items as $worryLevel) {
            $this->items[] = new Item((string) (int) $worryLevel); // Double cast to remove extra spaces
        }
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    public function setDivisionTest(int $divisionTest): void
    {
        $this->divisionTest = $divisionTest;
    }

    public function setMonkeyToThrowIfTrue(int $monkeyToThrowIfTrue): void
    {
        $this->monkeyToThrowIfTrue = $monkeyToThrowIfTrue;
    }

    public function setMonkeyToThrowIfFalse(int $monkeyToThrowIfFalse): void
    {
        $this->monkeyToThrowIfFalse = $monkeyToThrowIfFalse;
    }

    public function play(bool $useDynamicGCD = false): ?\Generator
    {
        if ($useDynamicGCD) {
            $previous = null;
            $maxGCD = '0';

            foreach ($this->items as $item) {
                if (null !== $previous) {
                    $maxGCD = max($maxGCD, $this->gcd($item->getWorryLevel(), $previous));
                }

                $previous = $item->getWorryLevel();
            }
        } else {
            $maxGCD = self::WORRY_LEVEL_ADJUSTMENT_RATIO;
        }

        foreach ($this->items as $item) {
            ++$this->nbInspectedObjects;

            $item->setWorryLevel($this->calculateWorryLevel($item, $maxGCD));

            yield [$item, $this->monkeyToSend($item)];
        }
    }

    public function sendItemToMonkey(Item $item, Monkey $receiver): void
    {
        $this->removeItem($item);

        $receiver->grabItem($item);
    }

    public function grabItem(Item $item): void
    {
        $this->items[] = $item;
    }

    private function removeItem(Item $itemToRemove): void
    {
        foreach ($this->items as $i => $item) {
            if ($itemToRemove === $item) {
                unset($this->items[$i]);

                break;
            }
        }
    }

    private function calculateWorryLevel(Item $item, string $maxGCD): string
    {
        [$left, $operator, $right] = explode(' ', $this->operation);

        $left = 'old' === $left ? $item->getWorryLevel() : $left;
        $right = 'old' === $right ? $item->getWorryLevel() : $right;
        $worryLevel = match ($operator) {
            '*' => bcmul($left, $right),
            '+' => bcadd($left, $right),
        };

        return $this->adjustWorryLevel($worryLevel, $maxGCD);
    }

    private function adjustWorryLevel(string $level, string $maxGCD): string
    {
        if ('0' === $maxGCD) {
            return $level;
        }

        return (string) round((int) bcdiv($level, $maxGCD), PHP_ROUND_HALF_DOWN);
    }

    private function monkeyToSend(Item $item): int
    {
        return 0 === $item->getWorryLevel() % $this->divisionTest
            ? $this->monkeyToThrowIfTrue
            : $this->monkeyToThrowIfFalse;
    }

    private function gcd(string $a, string $b): string
    {
        if ('0' === $b) {
            return '0';
        }

        return bcmod($a, $b) ? $this->gcd($b, bcmod($a, $b)) : $b;
    }
}
