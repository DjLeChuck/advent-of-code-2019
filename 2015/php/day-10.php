<?php

/*
 * Parts one and two are OK.
 */

$data = trim(file_get_contents('inputs/day-10.txt'));

ini_set('memory_limit', -1);

function calculate($input, $nb_iterations) {
    for ($x = 1; $x <= $nb_iterations; $x++) {
        $new    = '';
        $count  = 0;
        $prev   = '';

        foreach (str_split($input) as $char) {
            if ($prev !== $char && 0 < $count) {
                $new    .= $count.$prev;
                $count  = 0;
            }

            $count++;

            $prev = $char;
        }

        $input = $new.$count.$prev;
    }

    return $input;
}

$one = calculate($data, 40);

echo sprintf('First part: %u', strlen($one)).PHP_EOL;
echo sprintf('Second part: %u', strlen(calculate($one, 10))).PHP_EOL;
