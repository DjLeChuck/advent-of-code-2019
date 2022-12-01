<?php

/*
 * Parts one and two are OK.
 */

$data   = trim(file_get_contents('inputs/day-06.txt'));
$map    = ['one' => [], 'two' => []];

ini_set('memory_limit', -1);
set_time_limit(-1);

for ($x = 0; $x <= 999; $x++) {
    $map['one'][$x] = [];
    $map['two'][$x] = [];

    for ($y = 0; $y <= 999; $y++) {
        $map['one'][$x][$y] = 0;
        $map['two'][$x][$y] = 0;
    }
}

foreach (explode("\n", $data) as $line) {
    $parts  = explode(' ', str_replace('turn ', '', $line));
    $action = $parts[0];
    $coords = [
        explode(',', $parts[1]),
        explode(',', $parts[3]),
    ];

    for ($x = $coords[0][0]; $x <= $coords[1][0]; $x++) {
        for ($y = $coords[0][1]; $y <= $coords[1][1]; $y++) {
            switch ($action) {
                case 'on':
                    $map['one'][$x][$y] = 1;
                    $map['two'][$x][$y] += 1;
                    break;
                case 'off':
                    $map['one'][$x][$y] = 0;
                    $map['two'][$x][$y] -= 1;
                    $map['two'][$x][$y] = max($map['two'][$x][$y], 0);
                    break;
                case 'toggle':
                    $map['one'][$x][$y] = (int) !$map['one'][$x][$y];
                    $map['two'][$x][$y] += 2;
                    break;
            }
        }
    }
}

$total_one  = 0;
$total_two  = 0;

for ($x = 0; $x <= 999; $x++) {
    for ($y = 0; $y <= 999; $y++) {
        if (1 === $map['one'][$x][$y]) {
            $total_one++;
        }

        $total_two += $map['two'][$x][$y];
    }
}

echo sprintf('First part: %u', $total_one).PHP_EOL;
echo sprintf('Second part: %u', $total_two).PHP_EOL;
