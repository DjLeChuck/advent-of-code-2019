<?php

/*
 * Parts one and two are OK.
 */

$data   = trim(file_get_contents('inputs/day-02.txt'));
$total  = 0;

foreach (explode("\n", $data) as $size) {
    list($l, $w, $h)    = explode('x', $size);
    $min                = min($l * $w, $w * $h, $h * $l);
    $sizes              = [$l, $w, $h];

    sort($sizes);
    array_pop($sizes);

    $total      += 2 * $l * $w + 2 * $w * $h + 2 * $h * $l + $min;
    $sizes      = array_values($sizes);
    $total_b    += 2 * $sizes[0] + 2 * $sizes[1] + $l * $w * $h;
}

echo sprintf('First part: %u', $total).PHP_EOL;
echo sprintf('Second part: %u', $total_b).PHP_EOL;
