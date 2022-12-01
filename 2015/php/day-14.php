<?php

/*
 * Parts one and two are OK.
 */

$data               = trim(file_get_contents('inputs/day-14.txt'));
$reindeers          = [];
$flying_duration    = 2503;
$max                = ['first' => 0, 'second' => 0];

foreach (explode("\n", $data) as $line) {
    $matches = [];

    preg_match('`^([a-zA-Z]*) can fly ([0-9]*) km/s for ([0-9]*) seconds, but then must rest for ([0-9]*) seconds\.$`', $line, $matches);

    $scores[$matches[1]]    = 0;
    $reindeers[$matches[1]] = [
        'speed'     => $matches[2],
        'fly'       => $matches[3],
        'rest'      => $matches[4],
        'action'    => 'flying',
        'countdown' => [
            'fly'   => $matches[3],
            'rest'  => $matches[4],
        ],
        'scores'    => [
            'first'     => 0,
            'second'    => 0,
        ],
    ];
}

for ($x = 1; $x <= $flying_duration; $x++) {
    $max_turn = 0;

    foreach ($reindeers as $reindeer => &$data) {
        if ('flying' === $data['action']) {
            $data['scores']['first'] += $data['speed'];

            --$data['countdown']['fly'];

            // Check if reindeer must rest
            if (0 === $data['countdown']['fly']) {
                $data['action']             = 'resting';
                $data['countdown']['rest']  = $data['rest'];
            }
        } else {
            --$data['countdown']['rest'];

            // If countdown done, back to flying
            if (0 === $data['countdown']['rest']) {
                $data['action']             = 'flying';
                $data['countdown']['fly']   = $data['fly'];
            }
        }

        $max_turn = max($max_turn, $data['scores']['first']);
    }

    foreach ($reindeers as &$data) {
        if ($data['scores']['first'] === $max_turn) {
            $data['scores']['second'] += 1;
        }

        $max['first']   = max($max['first'], $data['scores']['first']);
        $max['second']  = max($max['second'], $data['scores']['second']);
    }
}

echo sprintf('First part: %u', $max['first']).PHP_EOL;
echo sprintf('Second part: %u', $max['second']).PHP_EOL;
