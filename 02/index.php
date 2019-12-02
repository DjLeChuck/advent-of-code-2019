<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

$input = trim(file_get_contents(__DIR__.'/input.txt'));

$assertions = [
    '1,0,0,0,99'                    => '2,0,0,0,99',
    '2,3,0,3,99'                    => '2,3,0,6,99',
    '2,4,4,5,99,0'                  => '2,4,4,5,99,9801',
    '1,1,1,4,99,5,6,0,99'           => '30,1,1,4,2,5,6,0,99',
    '1,9,10,3,2,3,11,0,99,30,40,50' => '3500,9,10,70,2,3,11,0,99,30,40,50',
];

foreach ($assertions as $list => $expectation) {
    $result = implode(',', buildIntcode($list));

    if ($result !== $expectation) {
        dump(sprintf('Error for the list %s in assertion one. Expect %s but got %s.', $list, $expectation, $result));
    }
}

$newIntcode = buildIntcode($input, 12, 2);

dump('Value at position 0: '.$newIntcode[0]);

$partTwoResult = 19690720;

for ($noun = 0; $noun <= 99; $noun++) {
    for ($verb = 0; $verb <= 99; $verb++) {
        $newIntcode = buildIntcode($input, $noun, $verb);

        if ($partTwoResult === $newIntcode[0]) {
            dump('Result found. Answer: '.(100 * $noun + $verb));

            break 2;
        }
    }
}

/**
 * @param string   $list
 * @param int|null $noun
 * @param int|null $verb
 *
 * @return array
 */
function buildIntcode(string $list, ?int $noun = null, ?int $verb = null): array
{
    $i       = 0;
    $numbers = array_map(static function ($x) {
        return (int) $x;
    }, explode(',', $list));

    if (null !== $noun && null !== $verb) {
        $numbers[1] = $noun;
        $numbers[2] = $verb;
    }

    do {
        $opcode = $numbers[$i];

        if (99 === $opcode) {
            continue;
        }

        switch ($opcode) {
            case 1:
                $numbers[$numbers[$i + 3]] = $numbers[$numbers[$i + 1]] + $numbers[$numbers[$i + 2]];
                break;
            case 2:
                $numbers[$numbers[$i + 3]] = $numbers[$numbers[$i + 1]] * $numbers[$numbers[$i + 2]];
                break;
        }

        $i += 4;
    } while ($opcode !== 99);

    return $numbers;
}
