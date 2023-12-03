<?php

declare(strict_types=1);

namespace App\Resolvers\Y2023;

use App\DTO\Solution;
use App\DTO\Y2023D03\Number;
use App\Resolvers\ResolverInterface;

class D03 implements ResolverInterface
{
    private const CELLS_OFFSETS = [
        [-1, -1], // Top left
        [0, -1],  // Top middle
        [1, -1],  // Top right
        [-1, 0],  // Left
        [0, 0],   // Current
        [1, 0],   // Right
        [-1, 1],  // Bottom left
        [0, 1],   // Bottom middle
        [1, 1],   // Bottom right
    ];

    private array $schema = [];

    public function resolve(array $input): Solution
    {
        $numbers = [];

        // Build schema and grab numbers
        foreach ($input as $y => $row) {
            if (empty($row)) {
                continue;
            }

            foreach (str_split($row) as $x => $cell) {
                $this->schema[$y][$x] = $cell;
            }

            $matches = [];
            preg_match_all('(\d+)', $row, $matches, PREG_OFFSET_CAPTURE);

            foreach ($matches[0] as $data) {
                $numbers[] = new Number((int) $data[0], $data[1], $y);
            }
        }

        $totalOne = 0;

        // Analyze numbers
        foreach ($numbers as $number) {
            if ($this->numberIsValid($number)) {
                $totalOne += $number->getValue();
            }
        }

        return new Solution($totalOne);
    }

    private function numberIsValid(Number $number): bool
    {
        $numberLen = \strlen((string) $number->getValue());

        for ($x = 0; $x < $numberLen; $x++) {
            if ($this->isValidCell($number->getY(), $number->getX() + $x)) {
                return true;
            }
        }

        return false;
    }

    private function isValidCell(int $y, int $x): bool
    {
        foreach (self::CELLS_OFFSETS as $offset) {
            if (!preg_match('/[0-9|.]/', ($this->schema[$y + $offset[0]][$x + $offset[1]] ?? '.'))) {
                return true;
            }
        }

        return false;
    }
}
