<?php

declare(strict_types=1);

namespace App\DTO\Y2022D12;

class SequencePrinter
{
    private TerrainCost $terrainCost;
    /** @var Point[] */
    private iterable $sequence;
    private string $emptyTileToken = '-';
    private int $tileSize = 3;
    private string $padToken = ' ';

    /**
     * @param TerrainCost     $terrainCost
     * @param iterable<Point> $sequence
     */
    public function __construct(TerrainCost $terrainCost, iterable $sequence)
    {
        $this->terrainCost = $terrainCost;
        $this->sequence = $sequence;
    }

    public function getEmptyTileToken(): string
    {
        return $this->emptyTileToken;
    }

    public function setEmptyTileToken(string $emptyTileToken): void
    {
        $this->emptyTileToken = $emptyTileToken;
    }

    public function getTileSize(): int
    {
        return $this->tileSize;
    }

    public function setTileSize(int $tileSize): void
    {
        if ($tileSize < 1) {
            throw new \InvalidArgumentException("Invalid tile size: $tileSize");
        }

        $this->tileSize = $tileSize;
    }

    public function getPadToken(): string
    {
        return $this->padToken;
    }

    public function setPadToken(string $padToken): void
    {
        $this->padToken = $padToken;
    }

    public function printSequence(): void
    {
        $board = $this->generateEmptyBoard();

        $step = 1;
        foreach ($this->sequence as $position) {
            $board[$position->getX()][$position->getY()] = $this->getTile((string) $step);

            $step++;
        }

        $stringBoard = [];

        foreach ($board as $row) {
            $stringBoard[] = implode('', $row);
        }

        echo implode("\n", $stringBoard).PHP_EOL;
    }

    /**
     * @return string[][]
     */
    private function generateEmptyBoard(): array
    {
        $emptyTile = $this->getTile($this->getEmptyTileToken());

        $emptyRow = array_fill(0, $this->terrainCost->getTotalColumns(), $emptyTile);

        return array_fill(0, $this->terrainCost->getTotalRows(), $emptyRow);
    }

    private function getTile(string $value): string
    {
        return str_pad($value, $this->getTileSize(), $this->getPadToken(), STR_PAD_LEFT);
    }
}
