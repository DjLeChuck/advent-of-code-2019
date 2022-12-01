<?php

/*
 * Part one is OK.
 */

$data = trim(file_get_contents('inputs/day-05.txt'));

function isValid($str) {
    return (
        // three vowels
        preg_match('`(\w*[aeiou]\w*){3,}`', $str) &&
        // one repeating letter
        preg_match('`\w*(\w)\1\w*`', $str) &&
        // no forbidden sequence
        preg_match('`^((?!ab|cd|pq|xy)\w)*$`', $str)
    );
}

$valid = 0;

foreach (explode("\n", $data) as $str) {
    $valid += (int) isValid($str);
}

echo sprintf('First part: %u', $valid).PHP_EOL;
