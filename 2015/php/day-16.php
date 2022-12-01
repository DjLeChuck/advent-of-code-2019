<?php

/*
 * Parts one and two are OK.
 */

$data               = trim(file_get_contents('inputs/day-16.txt'));
$needs              = [
    'children'      => 3,
    'cats'          => 7,
    'samoyeds'      => 2,
    'pomeranians'   => 3,
    'akitas'        => 0,
    'vizslas'       => 0,
    'goldfish'      => 5,
    'trees'         => 3,
    'cars'          => 2,
    'perfumes'      => 1,
];
$signs              = [
    'children'      => '=',
    'cats'          => '>',
    'samoyeds'      => '=',
    'pomeranians'   => '<',
    'akitas'        => '=',
    'vizslas'       => '=',
    'goldfish'      => '<',
    'trees'         => '>',
    'cars'          => '=',
    'perfumes'      => '=',
];
$aunt_number        = 0;
$real_aunt_number   = 0;

foreach (explode("\n", $data) as $line) {
    $matches = [];

    preg_match('`^Sue ([0-9]{1,3}): ([a-z]*): ([0-9]*), ([a-z]*): ([0-9]*), ([a-z]*): ([0-9]*)$`', $line, $matches);

    $good_real_aunt = true;
    $good_aunt      = true;
    $aunt_data      = [
        $matches[2] => (int) $matches[3],
        $matches[4] => (int) $matches[5],
        $matches[6] => (int) $matches[7],
    ];

    foreach ($needs as $key => $value) {
        if (!array_key_exists($key, $aunt_data)) {
            continue;
        }

        if ($value !== $aunt_data[$key]) {
            $good_aunt = false;
        }

        switch ($signs[$key]) {
            case '<':
                $good_real_aunt &= ($value > $aunt_data[$key]);
                break;
            case '>':
                $good_real_aunt &= ($value < $aunt_data[$key]);
                break;
            case '=':
                $good_real_aunt &= ($value === $aunt_data[$key]);
                break;
        }
    }

    if ($good_aunt) {
        $aunt_number = $matches[1];
    }

    if ($good_real_aunt) {
        $real_aunt_number = $matches[1];
    }
}

echo sprintf('First part: %u', $aunt_number).PHP_EOL;
echo sprintf('Second part: %u', $real_aunt_number).PHP_EOL;
