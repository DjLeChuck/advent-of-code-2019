<?php

declare(strict_types=1);

namespace App\AdventOfCode;

use Symfony\Component\HttpClient\HttpClient;

class InputGrabber
{
    public function __construct(
        private bool $useExampleInput,
        private string $exampleInputsDirectory,
    ) {
    }

    public function getInput(int $year, int $day): array
    {
        if ($this->useExampleInput) {
            return $this->getExampleInput($year, $day);
        }

        return $this->getRealInput($year, $day);
    }

    private function getExampleInput(int $year, int $day): array
    {
        $fullDay = str_pad((string) $day, 2, '0', STR_PAD_LEFT);
        $file = $this->exampleInputsDirectory . '/Y' . $year . '/D' . $fullDay . '.txt';
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(sprintf('No example input for Y%uD%u', $year, $fullDay));
        }

        return explode("\n", file_get_contents($file));
    }

    private function getRealInput(int $year, int $day): array
    {
        $client = HttpClient::createForBaseUri('https://adventofcode.com/', [
            'headers' => [
                'Cookie: session=' . $_ENV['AOC_SESSION'],
            ],
        ]);

        return explode(
            "\n",
            $client->request('GET', sprintf('%u/day/%u/input', $year, $day))->getContent()
        );
    }
}
