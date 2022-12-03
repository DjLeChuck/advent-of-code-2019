<?php

declare(strict_types=1);

require '../../vendor/autoload.php';

$input = explode("\n", file_get_contents('./input.txt'));

// First part
$sumPriorities = 0;

foreach ($input as $content) {
    if (empty($content)) {
        continue;
    }

    $chars = str_split($content);
    $count = \count($chars);
    $firstCompartment = array_slice($chars, 0, $count / 2);
    $secondCompartment = array_slice($chars, $count / 2);

    sumPriorities($sumPriorities, $firstCompartment, $secondCompartment);
}

dump('First part - Sum priorities: '.$sumPriorities);

// Second part
$sumPriorities = 0;

while (!empty($input)) {
    // Group backs by three
    $group = array_splice($input, 0, 3);
    if (3 !== \count($group)) {
        continue;
    }

    // Split by chars on each group
    array_walk($group, static function(&$row) {
        $row = str_split($row);
    });

    sumPriorities($sumPriorities, ...$group);
}

dump('Second part - Sum priorities: '.$sumPriorities);

function sumPriorities(int &$priorities, ...$array): void
{
    $intersection = array_unique(array_intersect(...$array));

    foreach ($intersection as $char) {
        // Convert char to lower, then integer between 1 and 26
        $priorities += ord(mb_strtolower($char)) - 96;

        // If uppercase letter, add 26
        if (preg_match('`^[A-Z]$`', $char)) {
            $priorities += 26;
        }
    }
}
