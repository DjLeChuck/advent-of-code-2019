<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        [$stacks, $moves] = $this->parseInput($input);
        $firstPart = $stacks;
        $secondPart = $stacks;

        foreach ($moves as $move) {
            if (empty($move)) {
                continue;
            }

            $matches = [];

            // move z from x to y
            preg_match('`^move (\d+) from (\d+) to (\d+)$`', $move, $matches);
            if (4 !== \count($matches)) {
                throw new \InvalidArgumentException('Unparseable move: '.$move);
            }

            [, $numberToMove, $from, $to] = $matches;
            --$from;
            --$to;

            // CrateMover 9000
            for ($x = 0; $x < $numberToMove; ++$x) {
                $firstPart[$to][] = array_pop($firstPart[$from]);
            }

            // CrateMover 9001
            array_push($secondPart[$to], ...array_splice($secondPart[$from], -$numberToMove));
        }

        $popStack = static fn($stack) => array_pop($stack);

        return new Solution(
            implode('', array_map($popStack, $firstPart)),
            implode('', array_map($popStack, $secondPart))
        );
    }

    private function parseInput(array $input): array
    {
        $stacks = [];
        $line = 0;

        foreach ($input as $line => $row) {
            // Empty line, no more crate.
            if ('' === $row) {
                break;
            }

            foreach (str_split($row) as $i => $char) {
                if ('A' <= $char && 'Z' >= $char) {
                    if (!isset($stacks[$i])) {
                        $stacks[$i] = [];
                    }

                    $stacks[$i][] = $char;
                }
            }
        }

        ksort($stacks);

        array_walk($stacks, static fn(array &$row) => $row = array_reverse($row));

        return [array_values($stacks), array_filter(array_slice($input, $line))];
    }
}
