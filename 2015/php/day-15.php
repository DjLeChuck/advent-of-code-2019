<?php

/*
 * Nothing is OK.
 */

$data = trim(file_get_contents('inputs/day-15.txt'));
$data = <<<DAT
Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8
Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3
DAT;
$lines          = explode("\n", $data);
$ingredients    = [];
$ratio          = 100 / count($lines);

foreach ($lines as $line) {
    $matches = [];

    preg_match('`([a-zA-Z]*): capacity (-?[0-9]*), durability (-?[0-9]*), flavor (-?[0-9]*), texture (-?[0-9]*), calories (-?[0-9]*)`', $line, $matches);

    $ingredients[$matches[1]] = [
        'capacity'      => (int) $matches[2],
        'durability'    => (int) $matches[3],
        'flavor'        => (int) $matches[4],
        'texture'       => (int) $matches[5],
        'calories'      => (int) $matches[6],
        'ratio'         => $ratio,
    ];
}

$ratio      = 100 / count($ingredients);
$continue   = true;

do {
    $properties = [
        'capacity'      => 0,
        'durability'    => 0,
        'flavor'        => 0,
        'texture'       => 0,
        'calories'      => 0,
    ];

    foreach ($ingredients as $data) {
        $properties['capacity'] += $data['capacity'] * $data['ratio'];
        $properties['durability'] += $data['durability'] * $data['ratio'];
        $properties['flavor'] += $data['flavor'] * $data['ratio'];
        $properties['texture'] += $data['texture'] * $data['ratio'];
    }

    var_dump($properties);

    $continue = false;
} while ($continue);
