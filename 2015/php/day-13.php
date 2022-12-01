<?php

/*
 * Nothing is OK.
 */

$data   = trim(file_get_contents('inputs/day-13.txt'));
$map    = [];

foreach (explode("\n", $data) as $line) {
    $tmp = [];

    preg_match('`^(?P<a>[a-zA-Z]+) would (?P<action>gain|lose) (?P<amount>[0-9]+) happiness units by sitting next to (?P<b>[a-zA-Z]+)\.$`', $line, $tmp);

    $amount = 'gain' === $tmp['action'] ? $tmp['amount'] : -$tmp['amount'];

    $map[$tmp['a']][$tmp['b']] = (int) $amount;
}

$happiness = 0;

foreach ($map as $a => $b_data) {
    $min    = PHP_INT_MAX;
    $b      = null;

    foreach ($b_data as $new_b => $amount) {
        if ($amount < $min) {
            $b      = $new_b;
            $min    = $amount;
        }
    }

    $happiness += $amount;

    var_dump($a, $b, $amount);
}

echo sprintf('First part: %u', $happiness).PHP_EOL;
