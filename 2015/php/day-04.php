<?php

/*
 * Parts one and two are OK.
 */

$data       = trim(file_get_contents('inputs/day-04.txt'));
$number     = 0;
$hash       = null;
$number_one = null;

do {
    set_time_limit(1);

    $hash = md5($data.++$number);

    if (null === $number_one && substr($hash, 0, 5) === '00000') {
        $number_one = $number;
    }
} while (substr($hash, 0, 6) !== '000000');

echo sprintf('First part: %u', $number_one).PHP_EOL;
echo sprintf('Second part: %u', $number).PHP_EOL;
