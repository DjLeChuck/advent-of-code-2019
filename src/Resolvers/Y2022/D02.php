<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\Resolvers\ResolverInterface;

class D02 implements ResolverInterface
{
    private const LOSE = 0;
    private const DRAW = 3;
    private const WIN = 6;

    public function resolve(array $input): void
    {
        $choiceScores = [
            'X' => 1,
            'Y' => 2,
            'Z' => 3,
        ];

        /*
         * A for Rock, B for Paper, and C for Scissors
         * X for Rock, Y for Paper, and Z for Scissors
         */
        $roundScores = [
            'AX' => self::DRAW,
            'AY' => self::WIN,
            'AZ' => self::LOSE,
            'BX' => self::LOSE,
            'BY' => self::DRAW,
            'BZ' => self::WIN,
            'CX' => self::WIN,
            'CY' => self::LOSE,
            'CZ' => self::DRAW,
        ];

        $choiceForWin = [
            'A' => 'Y',
            'B' => 'Z',
            'C' => 'X',
        ];
        $choiceForLose = [
            'A' => 'Z',
            'B' => 'X',
            'C' => 'Y',
        ];
        $choiceForDraw = [
            'A' => 'X',
            'B' => 'Y',
            'C' => 'Z',
        ];

        $firstScore = 0;
        $secondScore = 0;

        // X means you need to lose, Y means you need to end the round in a draw, and Z means you need to win

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            [$opposant, $me] = explode(' ', $row);

            $firstScore += $roundScores[$opposant.$me];
            $firstScore += $choiceScores[$me];

            if ('X' === $me) {
                // Need to lose
                $me = $choiceForLose[$opposant];
            } elseif ('Y' === $me) {
                // Need to draw
                $me = $choiceForDraw[$opposant];
            } elseif ('Z' === $me) {
                // Need to win
                $me = $choiceForWin[$opposant];
            }

            $secondScore += $roundScores[$opposant.$me];
            $secondScore += $choiceScores[$me];
        }

        dump('First score: '.$firstScore);
        dump('Second score: '.$secondScore);
    }
}
