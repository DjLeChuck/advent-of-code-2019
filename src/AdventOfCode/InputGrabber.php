<?php

declare(strict_types=1);

namespace App\AdventOfCode;

use Symfony\Component\HttpClient\HttpClient;

class InputGrabber
{
    public function getInput(int $year, int $day): array
    {
        $client = HttpClient::createForBaseUri('https://adventofcode.com/', [
            'headers' => [
                'Cookie: session='.$_ENV['AOC_SESSION'],
            ],
        ]);

        return explode(
            "\n",
            $client->request('GET', sprintf('%u/day/%u/input', $year, $day))->getContent()
        );
    }
}
