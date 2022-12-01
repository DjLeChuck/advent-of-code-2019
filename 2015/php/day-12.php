<?php

/*
 * Part one is OK.
 */

$data   = trim(file_get_contents('inputs/day-12.txt'));
$chars  = [];
$total  = 0;

foreach (str_split($data) as $char) {
    if ('-' === $char || is_numeric($char)) {
        $chars[] = $char;

        continue;
    } elseif (!empty($chars)) {
        $total += (int) implode('', $chars);

        $chars = [];
    }
}

echo sprintf('First part: %u', $total).PHP_EOL;
