<?php

declare(strict_types=1);

require '../../vendor/autoload.php';

$input = explode("\n", file_get_contents('./input.txt'));

CONST LOSE = 0;
const DRAW = 3;
const WIN = 6;

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
    'AX' => DRAW,
    'AY' => WIN,
    'AZ' => LOSE,
    'BX' => LOSE,
    'BY' => DRAW,
    'BZ' => WIN,
    'CX' => WIN,
    'CY' => LOSE,
    'CZ' => DRAW,
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
