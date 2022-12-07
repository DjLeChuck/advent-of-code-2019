<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    public function resolve(array $input): void
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
                dump('Unparseable move: '.$move);

                continue;
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

        dump('First answer: '.implode('', array_map(static fn($stack) => array_pop($stack), $firstPart)));
        dump('Second answer: '.implode('', array_map(static fn($stack) => array_pop($stack), $secondPart)));
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
