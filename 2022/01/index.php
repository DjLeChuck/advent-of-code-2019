<?php

declare(strict_types=1);

require '../../vendor/autoload.php';

$input = explode("\n", file_get_contents('./input.txt'));
$calories = [];
$index = 0;

foreach ($input as $row) {
    // Ligne vide => changement d'elfe
    if ('' === $row) {
        ++$index;
    }

    if (!isset($calories[$index])) {
        $calories[$index] = 0;
    }

    $calories[$index] += (int) $row;
}

sort($calories);

dump('Max calories: '.end($calories));

$topThree = array_slice($calories, -3);

dump('Top three calories: '.array_reduce($topThree, static fn ($x, $y) => $y += $x, 0));
