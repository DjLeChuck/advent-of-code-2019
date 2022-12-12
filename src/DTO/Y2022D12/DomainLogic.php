<?php

declare(strict_types=1);

namespace App\DTO\Y2022D12;

use JMGQ\AStar\DomainLogicInterface;

class DomainLogic implements DomainLogicInterface
{
    private TerrainCost $terrainCost;
    /** @var Point[] */
    private array $positions;

    public function __construct(TerrainCost $terrainCost)
    {
        $this->terrainCost = $terrainCost;
        $this->positions = $this->generatePositions($terrainCost);
    }

    public function getAdjacentNodes(mixed $node): iterable
    {
        assert($node instanceof Point);

        $adjacentNodes = [];

        [$startingRow, $endingRow, $startingColumn, $endingColumn] = $this->calculateAdjacentBoundaries($node);
        $nodeCost = $this->terrainCost->getCost($node->getX(), $node->getY());

        for ($row = $startingRow; $row <= $endingRow; $row++) {
            for ($column = $startingColumn; $column <= $endingColumn; $column++) {
                $adjacentNode = $this->positions[$row][$column];

                if (
                    !$node->isEqualTo($adjacentNode)
                    && !$node->isDiagonal($adjacentNode)
                    && \in_array(
                        $this->terrainCost->getCost($adjacentNode->getX(), $adjacentNode->getY()),
                        [$nodeCost - 1, $nodeCost, $nodeCost + 1],
                        true
                    )
                ) {
                    $adjacentNodes[] = $adjacentNode;
                }
            }
        }

        return $adjacentNodes;
    }

    public function calculateRealCost(mixed $node, mixed $adjacent): float|int
    {
        if ($node->isAdjacentTo($adjacent)) {
            return $this->terrainCost->getCost($adjacent->getX(), $adjacent->getY());
        }

        return TerrainCost::INFINITE;
    }

    public function calculateEstimatedCost(mixed $fromNode, mixed $toNode): float|int
    {
        assert($fromNode instanceof Point);
        assert($toNode instanceof Point);

        $rowFactor = ($fromNode->getX() - $toNode->getX()) ** 2;
        $columnFactor = ($fromNode->getY() - $toNode->getY()) ** 2;

        return sqrt($rowFactor + $columnFactor);
    }

    private function calculateAdjacentBoundaries(Point $point): array
    {
        if ($point->getX() === 0) {
            $startingRow = 0;
        } else {
            $startingRow = $point->getX() - 1;
        }

        if ($point->getX() === $this->terrainCost->getTotalRows() - 1) {
            $endingRow = $point->getX();
        } else {
            $endingRow = $point->getX() + 1;
        }

        if ($point->getY() === 0) {
            $startingColumn = 0;
        } else {
            $startingColumn = $point->getY() - 1;
        }

        if ($point->getY() === $this->terrainCost->getTotalColumns() - 1) {
            $endingColumn = $point->getY();
        } else {
            $endingColumn = $point->getY() + 1;
        }

        return [$startingRow, $endingRow, $startingColumn, $endingColumn];
    }

    private function generatePositions(TerrainCost $terrainCost): array
    {
        $positions = [];

        for ($x = 0; $x < $terrainCost->getTotalRows(); $x++) {
            for ($y = 0; $y < $terrainCost->getTotalColumns(); $y++) {
                $positions[$x][$y] = new Point($x, $y);
            }
        }

        return $positions;
    }
}
