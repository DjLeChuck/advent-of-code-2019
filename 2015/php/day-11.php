<?php

/*
 * Nothing is OK.
 */

$data   = trim(file_get_contents('inputs/day-11.txt'));
$new    = '';

foreach (str_split($data) as $char) {
    $new .= chr(ord($char) + 1);
}

echo $new.PHP_EOL;
