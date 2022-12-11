<?php

declare(strict_types=1);

namespace App\Resolvers\Y2022;

use App\DTO\Solution;
use App\Resolvers\IOAwareInterface;
use App\Resolvers\IOAwareTrait;
use App\Resolvers\ResolverInterface;
use Symfony\Component\Console\Cursor;

class D10 implements ResolverInterface, IOAwareInterface
{
    use IOAwareTrait;

    private const NOOP = 'noop';
    private const INTERESTING_SIGNALS = [20, 60, 100, 140, 180, 220];
    private const CRT_WIDTH = 40;
    private const CRT_HEIGHT = 6;
    private const CRT_ROW_DELTA = 4;

    private int $cycle = 0;
    private int $x = 1;
    private int $signalStrength = 0;
    private array $crt = [];
    private int $currentCrtRow = 0;

    public function resolve(array $input): Solution
    {
        $this->initCrt();

        foreach ($input as $row) {
            if (empty($row)) {
                continue;
            }

            ++$this->cycle;

            $this->setCrtPixel();
            $this->analyzeSignal();

            if (self::NOOP !== $row) {
                [, $size] = explode(' ', $row);

                $this->addInstruction((int) $size);
                $this->setCrtPixel();
            }
        }

        $this->displayCrt();

        return new Solution($this->signalStrength, '☝️  Réponse juste au-dessus (buguée :D)');
    }

    private function initCrt(): void
    {
        for ($x = 0; $x < self::CRT_HEIGHT; ++$x) {
            $this->crt[$x] = array_fill(0, self::CRT_WIDTH, '.');
        }
    }

    private function addInstruction(int $size): void
    {
        ++$this->cycle;

        $this->analyzeSignal();

        $this->x += $size;
    }

    private function setCrtPixel(): void
    {
        $position = $this->cycle % 40;

        if (\in_array($position, [$this->x - 1, $this->x, $this->x + 1], true)) {
            $this->crt[$this->currentCrtRow][$position] = '#';
        }
    }

    private function analyzeSignal(): void
    {
        if (!\in_array($this->cycle, self::INTERESTING_SIGNALS, true)) {
            return;
        }

        $this->signalStrength += $this->cycle * $this->x;

        ++$this->currentCrtRow;
    }

    private function displayCrt(): void
    {
        // return;
        $cursor = new Cursor($this->io);

        foreach ($this->crt as $row => $data) {
            foreach ($data as $column => $pixel) {
                $cursor->moveToPosition($column, $row + self::CRT_ROW_DELTA);

                $this->io->write($pixel);
            }
        }

        $this->io->writeln('');
        $this->io->writeln('');
    }
}
