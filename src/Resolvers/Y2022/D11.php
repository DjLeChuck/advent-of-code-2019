<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\DTO\Y2022D11\Monkey;
use App\Resolvers\ResolverInterface;

class D11 implements ResolverInterface
{
    /** @var Monkey[] */
    private array $monkeys = [];

    public function resolve(array $input): Solution
    {
        // First part
        $this->prepareMonkeys($input);

        for ($x = 0; $x < 20; ++$x) {
            foreach ($this->monkeys as $monkey) {
                foreach ($monkey->play() as $result) {
                    [$item, $receiver] = $result;

                    $monkey->sendItemToMonkey($item, $this->monkeys[$receiver]);
                }
            }
        }

        foreach ($this->monkeys as $number => $monkey) {
            $monkeysInspections[$number] = $monkey->getNbInspectedObjects();
        }

        sort($monkeysInspections);

        [$first, $second] = array_splice($monkeysInspections, -2);
        $firstAnswer = $first * $second;

        // Second part
        $this->prepareMonkeys($input);

        for ($x = 0; $x < 10000; ++$x) {
            foreach ($this->monkeys as $monkey) {
                foreach ($monkey->play(true) as $result) {
                    [$item, $receiver] = $result;

                    $monkey->sendItemToMonkey($item, $this->monkeys[$receiver]);
                }
            }
        }

        foreach ($this->monkeys as $number => $monkey) {
            $monkeysInspections[$number] = $monkey->getNbInspectedObjects();
        }

        sort($monkeysInspections);

        [$first, $second] = array_splice($monkeysInspections, -2);

        return new Solution($firstAnswer, ($first * $second).' (wrong)');
    }

    private function prepareMonkeys(array $input): void
    {
        $this->monkeys = [];

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            if (str_starts_with($row, 'Monkey ')) {
                $this->monkeys[] = new Monkey();

                continue;
            }

            $monkey = end($this->monkeys);
            if (false === $monkey) {
                throw new \LogicException('No monkey available.');
            }

            if (str_starts_with($row, '  Starting items:')) {
                $items = str_replace('  Starting items: ', '', $row);

                $monkey->setItems(explode(',', $items));

                continue;
            }

            if (str_starts_with($row, '  Operation:')) {
                $monkey->setOperation(str_replace('  Operation: new = ', '', $row));

                continue;
            }

            if (str_starts_with($row, '  Test:')) {
                $monkey->setDivisionTest((int) str_replace('  Test: divisible by ', '', $row));

                continue;
            }

            if (str_starts_with($row, '    If true:')) {
                $monkey->setMonkeyToThrowIfTrue((int) str_replace('    If true: throw to monkey ', '', $row));

                continue;
            }

            if (str_starts_with($row, '    If false:')) {
                $monkey->setMonkeyToThrowIfFalse((int) str_replace('    If false: throw to monkey ', '', $row));
            }
        }
    }
}
