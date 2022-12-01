<?php

/*
 * Parts one and two are OK.
 */

$data       = trim(file_get_contents('inputs/day-01.txt'));
$count      = 1;
$strlen     = strlen($data);
$basement   = null;

for ($i = 0; $i <= $strlen; $i++) {
    $count += '(' === $data[$i] ? 1 : -1;

    if (-1 === $count && null === $basement) {
        $basement = $i;
    }
}

echo sprintf('First part: %u', $count).PHP_EOL;
echo sprintf('Second part: %u', $basement).PHP_EOL;
