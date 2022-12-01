<?php

/*
 * Nothing is OK.
 */

$data   = trim(file_get_contents('inputs/day-09.txt'));
$map    = [];

foreach (explode("\n", $data) as $line) {
    list($from, , $to, , $distance) = explode(' ', $line);

    if (!array_key_exists($from, $map)) {
        $map[$from] = [];
    }

    if (!in_array($to, $map[$from])) {
        $map[$from][$to] = $distance;
    }
}

var_dump($map);
