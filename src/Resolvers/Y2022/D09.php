<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\ResolverInterface;

class D09 implements ResolverInterface
{
    private const UP = 'U';
    private const RIGHT = 'R';
    private const DOWN = 'D';
    private const LEFT = 'L';

    private array $grid = [
        0 => [
            0 => '#',
        ],
    ];
    private array $headCoords = ['x' => 0, 'y' => 0];
    private array $tailCoords = ['x' => 0, 'y' => 0];

    public function resolve(array $input): Solution
    {
        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            [$direction, $length] = explode(' ', $row);
            $length = (int) $length;

            match ($direction) {
                self::UP => $this->moveUp($length),
                self::RIGHT => $this->moveRight($length),
                self::DOWN => $this->moveDown($length),
                self::LEFT => $this->moveLeft($length),
                default => throw new \InvalidArgumentException(sprintf('Unknown direction "%s"', $direction)),
            };
        }

        $nbMark = 0;

        foreach ($this->grid as $range) {
            foreach ($range as $ignored) {
                ++$nbMark;
            }
        }

        return new Solution($nbMark);
    }

    private function moveUp(int $length): void
    {
        for ($i = 0; $i < $length; ++$i) {
            ++$this->headCoords['y'];

            if ($this->needToMoveTail()) {
                $this->tailCoords['x'] = $this->headCoords['x'];
                $this->tailCoords['y'] = $this->headCoords['y'] - 1;

                $this->markGrid();
            }
        }
    }

    private function moveRight(int $length): void
    {
        for ($i = 0; $i < $length; ++$i) {
            ++$this->headCoords['x'];

            if ($this->needToMoveTail()) {
                $this->tailCoords['x'] = $this->headCoords['x'] - 1;
                $this->tailCoords['y'] = $this->headCoords['y'];

                $this->markGrid();
            }
        }
    }

    private function moveDown(int $length): void
    {
        for ($i = 0; $i < $length; ++$i) {
            --$this->headCoords['y'];

            if ($this->needToMoveTail()) {
                $this->tailCoords['x'] = $this->headCoords['x'];
                $this->tailCoords['y'] = $this->headCoords['y'] + 1;

                $this->markGrid();
            }
        }
    }

    private function moveLeft(int $length): void
    {
        for ($i = 0; $i < $length; ++$i) {
            --$this->headCoords['x'];

            if ($this->needToMoveTail()) {
                $this->tailCoords['x'] = $this->headCoords['x'] + 1;
                $this->tailCoords['y'] = $this->headCoords['y'];

                $this->markGrid();
            }
        }
    }

    /**
     * Checks if the tail needs to move.
     *
     * @return bool
     */
    private function needToMoveTail(): bool
    {
        $validCoords = [
            [$this->headCoords['x'] - 1, $this->headCoords['y'] + 1], // top left
            [$this->headCoords['x'], $this->headCoords['y'] + 1], // top middle
            [$this->headCoords['x'] + 1, $this->headCoords['y'] + 1], // top right
            [$this->headCoords['x'] - 1, $this->headCoords['y']], // left
            [$this->headCoords['x'], $this->headCoords['y']], // same
            [$this->headCoords['x'] + 1, $this->headCoords['y']], // right
            [$this->headCoords['x'] - 1, $this->headCoords['y'] - 1], // bottom left
            [$this->headCoords['x'], $this->headCoords['y'] - 1], // bottom middle
            [$this->headCoords['x'] + 1, $this->headCoords['y'] - 1], // bottom right
        ];

        return !\in_array([$this->tailCoords['x'], $this->tailCoords['y']], $validCoords, true);
    }

    private function markGrid(): void
    {
        $this->grid[$this->tailCoords['x']][$this->tailCoords['y']] = '#';
    }
}
