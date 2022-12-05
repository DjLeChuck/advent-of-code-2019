<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D05 implements ResolverInterface
{
    public function resolve(array $input): void
    {
        /*
    [M]             [Z]     [V]
    [Z]     [P]     [L]     [Z] [J]
[S] [D]     [W]     [W]     [H] [Q]
[P] [V] [N] [D]     [P]     [C] [V]
[H] [B] [J] [V] [B] [M]     [N] [P]
[V] [F] [L] [Z] [C] [S] [P] [S] [G]
[F] [J] [M] [G] [R] [R] [H] [R] [L]
[G] [G] [G] [N] [V] [V] [T] [Q] [F]
 1   2   3   4   5   6   7   8   9
         */

        $stacks = [
            1 => ['G', 'F', 'V', 'H', 'P', 'S'],
            2 => ['G', 'J', 'F', 'B', 'V', 'D', 'Z', 'M'],
            3 => ['G', 'M', 'L', 'J', 'N'],
            4 => ['N', 'G', 'Z', 'V', 'D', 'W', 'P'],
            5 => ['V', 'R', 'C', 'B'],
            6 => ['V', 'R', 'S', 'M', 'P', 'W', 'L', 'Z'],
            7 => ['T', 'H', 'P'],
            8 => ['Q', 'R', 'S', 'N', 'C', 'H', 'Z', 'V'],
            9 => ['F', 'L', 'G', 'P', 'V', 'Q', 'J'],
        ];
        $moves = array_slice($input, 9);
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
}
