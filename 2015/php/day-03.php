<?php

/*
 * Parts one and two are OK.
 */

$data       = trim(file_get_contents('inputs/day-03.txt'));
$data_one   = str_split($data);
$data_two   = str_split($data, 2);
$map_one    = ['0,0' => 1];
$map_two    = [['0,0' => 1], ['0,0' => 1]];
$i_one      = 0;
$j_one      = 0;
$i_two      = [0 => 0, 1 => 0];
$j_two      = [0 => 0, 1 => 0];
$x          = 0;

foreach ($data_one as $dir) {
    $x_mod = $x % 2;

    switch ($dir) {
        case '>':
            $i_one++;
            $i_two[$x_mod]++;
            break;
        case '^':
            $j_one++;
            $j_two[$x_mod]++;
            break;
        case 'v':
            $j_one--;
            $j_two[$x_mod]--;
            break;
        case '<':
            $i_one--;
            $i_two[$x_mod]--;
            break;
    }

    if (!isset($map_one[sprintf('%d,%d', $i_one, $j_one)])) {
        $map_one[sprintf('%d,%d', $i_one, $j_one)] = 1;
    }

    $map_one[sprintf('%d,%d', $i_one, $j_one)]++;

    if (!isset($map_two[$x_mod][sprintf('%d,%d', $i_two[$x_mod], $j_two[$x_mod])])) {
        $map_two[$x_mod][sprintf('%d,%d', $i_two[$x_mod], $j_two[$x_mod])] = 1;
    }

    $map_two[$x_mod][sprintf('%d,%d', $i_two[$x_mod], $j_two[$x_mod])]++;

    $x++;
}

echo sprintf('First part: %u', count($map_one)).PHP_EOL;
echo sprintf('Second part: %u', count(array_merge($map_two[0], $map_two[1]))).PHP_EOL;
