<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

$input = file_get_contents(__DIR__.'/input.txt');

$assertions = [
    'one' => [
        12     => 2,
        14     => 2,
        1969   => 654,
        100756 => 33583,
    ],
    'two' => [
        12     => 2,
        14     => 2,
        1969   => 966,
        100756 => 50346,
    ],
];
$sumPartOne = 0;
$sumPartTwo = 0;

foreach ($assertions['one'] as $mass => $expectation) {
    $fuel = calculateFuel($mass, false);

    if ($fuel !== $expectation) {
        dump(sprintf('Error for the mass %u in assertion one. Expect %u but got %u.', $mass, $expectation, $fuel));
    }
}

foreach ($assertions['two'] as $mass => $expectation) {
    $fuel = calculateFuel($mass, true);

    if ($fuel !== $expectation) {
        dump(sprintf('Error for the mass %u in assertion two. Expect %u but got %u.', $mass, $expectation, $fuel));
    }
}

foreach (explode("\n", $input) as $line) {
    $line = trim($line);

    if (empty($line)) {
        continue;
    }

    $sumPartOne += calculateFuel((int) $line, false);
    $sumPartTwo += calculateFuel((int) $line, true);
}

dump('Part 1: '.$sumPartOne);
dump('Part 2: '.$sumPartTwo);

/**
 * Divide the mass by three, round down and finally substract 2.
 *
 * @param int  $mass
 * @param bool $includeFuel
 *
 * @return int
 */
function calculateFuel(int $mass, bool $includeFuel): int
{
    if (!$includeFuel) {
        return (int) (floor($mass / 3) - 2);
    }

    $fuel      = 0;
    $remaining = calculateFuel($mass, false);

    do {
        $fuel      += $remaining;
        $remaining = calculateFuel($remaining, false);
    } while ($remaining >= 0);

    return $fuel;
}
