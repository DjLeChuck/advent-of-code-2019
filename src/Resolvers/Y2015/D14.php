<?php

declare(strict_types=1);

namespace App\Resolvers\Y2015;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D14 implements ResolverInterface
{
    public function resolve(array $input): Solution
    {
        $reindeers = [];
        $flyingDuration = 2503;
        $max = ['first' => 0, 'second' => 0];

        foreach ($input as $line) {
            if (empty($line)) {
                continue;
            }

            $matches = [];

            preg_match(
                '`^([a-zA-Z]*) can fly (\d*) km/s for (\d*) seconds, but then must rest for (\d*) seconds\.$`',
                $line,
                $matches
            );

            $scores[$matches[1]] = 0;
            $reindeers[$matches[1]] = [
                'speed'     => $matches[2],
                'fly'       => $matches[3],
                'rest'      => $matches[4],
                'action'    => 'flying',
                'countdown' => [
                    'fly'  => $matches[3],
                    'rest' => $matches[4],
                ],
                'scores'    => [
                    'first'  => 0,
                    'second' => 0,
                ],
            ];
        }

        for ($x = 1; $x <= $flyingDuration; $x++) {
            $max_turn = 0;

            foreach ($reindeers as &$data) {
                if ('flying' === $data['action']) {
                    $data['scores']['first'] += $data['speed'];

                    --$data['countdown']['fly'];

                    // Check if reindeer must rest
                    if (0 === $data['countdown']['fly']) {
                        $data['action'] = 'resting';
                        $data['countdown']['rest'] = $data['rest'];
                    }
                } else {
                    --$data['countdown']['rest'];

                    // If countdown done, back to flying
                    if (0 === $data['countdown']['rest']) {
                        $data['action'] = 'flying';
                        $data['countdown']['fly'] = $data['fly'];
                    }
                }

                $max_turn = max($max_turn, $data['scores']['first']);
            }
            unset($data);

            foreach ($reindeers as &$data) {
                if ($data['scores']['first'] === $max_turn) {
                    $data['scores']['second'] += 1;
                }

                $max['first'] = max($max['first'], $data['scores']['first']);
                $max['second'] = max($max['second'], $data['scores']['second']);
            }
            unset($data);
        }

        return new Solution($max['first'], $max['second']);
    }
}
